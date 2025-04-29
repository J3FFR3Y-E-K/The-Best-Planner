import requests
import json
import os
from bs4 import BeautifulSoup
from datetime import datetime, timezone

# Using headers so we appear like an actual browser
headers = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)",
    "Accept": "application/json",
}

# Configuration
base_url = "https://montclair.campuslabs.com/engage/api/discovery/event/search"
take = 15
skip = 0
events_dict = {}

# Current UTC time formatted to get more events
now = datetime.now(timezone.utc).isoformat()

while True:
    response = requests.get(
        base_url,
        headers=headers,
        params={
            "endsAfter": now,
            "orderByField": "endsOn",
            "orderByDirection": "ascending",
            "status": "Approved",
            "take": take,
            "skip": skip,
            "query": ""
        },
        timeout=5
    )
    data = response.json()
    events = data.get("value", [])

    print(f"Skip {skip}: {len(events)} events")

    if not events:
        break

    for event in events:
        event_id = event["id"]

        if event_id in events_dict:
            continue  # Skip duplicates

        # Link to actual event to pull description
        detail_url = (
            f"https://montclair.campuslabs.com/engage/api/discovery/event/{event_id}"
        )

        # Request full event info
        try:
            detail_response = requests.get(detail_url, headers=headers, timeout=5)
            detail_data = detail_response.json()
            full_description = detail_data.get("description", "")

            # Clean HTML
            soup = BeautifulSoup(full_description, "html.parser")
            clean_description = soup.get_text(separator=" ").strip()

        except Exception as e:
            print(f"Failed to fetch details for event {event_id}: {e}")
            clean_description = ""

        event_data = {
            "title": event["name"],
            "date": event["startsOn"],
            "organization": event["organizationName"],
            "location": event["location"],
            "link": f"https://montclair.campuslabs.com/engage/event/{event_id}",
            "description": clean_description
        }

        events_dict[event_id] = event_data

        print(f"Scraped: {event['name']}")

    skip += take

# Save JSON in the same directory where scraper is
output_path = os.path.join(os.path.dirname(__file__), "events.json")

print(f"Saving file to {output_path}")

with open(output_path, "w") as f:
    print(f"Total events scraped: {len(events_dict)}")
    json.dump(list(events_dict.values()), f, indent=2)

print("Finished writing events.json successfully!")
