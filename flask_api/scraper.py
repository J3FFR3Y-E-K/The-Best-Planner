import requests
import json
import os 
from bs4 import BeautifulSoup


#using headers so we appear like an actual browser
headers = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)",
    "Accept": "application/json",
}

#making a maximum number of pages so we pull a limited number of events
MAX_PAGES = 20
page = 1
events_list = []

while page <= MAX_PAGES:
    response = requests.get(
        f"https://montclair.campuslabs.com/engage/api/discovery/event/search?pageNumber={page}",
        headers=headers, timeout=5
    )
    data = response.json()
    events = data["value"]

    print(f"Page {page}: {len(events)} events")

    if not events:
        break

    for event in events:
        event_id = event["id"]
        #Link to actual event to pull description
        detail_url = f"https://montclair.campuslabs.com/engage/api/discovery/event/{event_id}"

        #request full event info
        try:
            detail_response = requests.get(detail_url, headers=headers, timeout=5)
            detail_data = detail_response.json()
            full_description = detail_data.get("description", "")

            #clean HTML
            soup = BeautifulSoup(full_description, "html.parser")
            clean_description = soup.get_text(separator=" ").strip()

        except Exception as e:
            print(f"Failed to getch details for event {event_id}: {e}")
            full_description = ""


        event_data = {
            "title": event["name"],
            "date": event["startsOn"],
            "organization": event["organizationName"],
            "location": event["location"],
            "link": f"https://montclair.campuslabs.com/engage/event/{event['id']}",
            "description": clean_description
        }
        events_list.append(event_data)

        print(f"Scraped: {event['name']}")

    page += 1

#save json in the same directory where scrapper is
output_path = os.path.join(os.path.dirname(__file__), "events.json")

print(f"Saving File to {output_path}")

with open(output_path, "w") as f:
    print(f"Total events scraped: {len(events_list)}")
    json.dump(events_list, f, indent=2)

print("Finished writing events.json successfully!")
    
