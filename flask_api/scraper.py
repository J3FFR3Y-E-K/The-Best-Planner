import json
import os

import pymysql
import requests
from bs4 import BeautifulSoup

# MySQL database connection


db = pymysql.connect(
    host="localhost",
    user="lovei1_iandbuser",
    password="tfihp2371#3",
    database="lovei1_engageeventmanager"
)
cursor = db.cursor()

# Headers to appear as browser
headers = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)",
    "Accept": "application/json",
}

# Configuration
MAX_PAGES = 20
page = 1
events_list = []

while page <= MAX_PAGES:
    response = requests.get(
        f"https://montclair.campuslabs.com/engage/api/discovery/event/search?pageNumber={page}",
        headers=headers,
        timeout=5,
    )
    data = response.json()
    events = data.get("value", [])

    print(f"Page {page}: {len(events)} events")

    if not events:
        break

    for event in events:
        event_id = event.get("id")
        detail_url = (
            f"https://montclair.campuslabs.com/engage/api/discovery/event/{event_id}"
        )

        try:
            detail_response = requests.get(
                detail_url,
                headers=headers,
                timeout=5,
            )
            detail_data = detail_response.json()
            full_description = detail_data.get("description", "")
            ends_on = detail_data.get("endsOn")

            soup = BeautifulSoup(full_description, "html.parser")
            clean_description = soup.get_text(separator=" ").strip()

        except Exception as e:
            print(f"Failed to fetch details for event {event_id}: {e}")
            clean_description = ""
            ends_on = None

        # Prepare event data
        event_data = {
            "title": event.get("name"),
            "date": event.get("startsOn"),
            "organization": event.get("organizationName"),
            "location": event.get("location"),
            "link": f"https://montclair.campuslabs.com/engage/event/{event_id}",
            "description": clean_description,
            "end_date": ends_on if ends_on else event.get("startsOn"),
        }
        events_list.append(event_data)

        # Insert or update event in database
        sql = (
            """
            INSERT INTO events (EID, Name, Organization, Description, TimeStart, TimeEnd)
            VALUES (%s, %s, %s, %s, %s, %s)
            ON DUPLICATE KEY UPDATE
                Name=VALUES(Name),
                Organization=VALUES(Organization),
                Description=VALUES(Description),
                TimeStart=VALUES(TimeStart),
                TimeEnd=VALUES(TimeEnd)
            """
        )

        values = (
            event_id,
            event_data["title"],
            event_data["organization"],
            event_data["description"],
            event_data["date"],
            event_data["end_date"],
        )

        cursor.execute(sql, values)
        db.commit()

        print(f"Scraped and saved: {event_data['title']}")

    page += 1

# Optional: Save to local events.json file for backup/testing
output_path = os.path.join(os.path.dirname(__file__), "events.json")
print(f"Saving JSON backup to {output_path}")

with open(output_path, "w") as f:
    print(f"Total events scraped: {len(events_list)}")
    json.dump(events_list, f, indent=2)

# Close DB connection
cursor.close()
db.close()

print("Finished updating database and writing events.json.")