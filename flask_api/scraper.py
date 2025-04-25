import requests
from flask import Flask, jsonify
import json


headers = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)",
    "Accept": "application/json",
}

MAX_PAGES = 10
page = 1
events_list = []

while page <=MAX_PAGES:
    response = requests.get(
        f"https://montclair.campuslabs.com/engage/api/discovery/event/search?pageNumber={page}",
        headers=headers
    )
    data = response.json()
    events = data["value"]

    # Print how many events were found on this page
    print(f"Page {page}: {len(events)} events")

    if not events:
        break

    for event in events:
        event_data = {
            "title": event["name"],
            "date": event["startsOn"],
            "organization": event["organizationName"],
            "location": event["location"],
            "link": f"https://montclair.campuslabs.com/engage/event/{event['id']}",
            "description": event["description"]
        }
        events_list.append(event_data)

        # Print each event title
        print(f"Scraped: {event['name']}")

    page += 1

# Save to JSON
with open("events.json", "w") as f:
    json.dump(events_list, f, indent=2)
