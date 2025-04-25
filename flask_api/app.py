from flask import Flask, jsonify
import json
import os

app = Flask(__name__)
EVENTS_FILE = os.path.join(os.path.dirname(__file__), 'events.json')

@app.route('/')
def home():
    return '✅ Flask API running! Visit /api/events'

@app.route('/api/events')
def get_events():
    try:
        with open(EVENTS_FILE) as f:
            events = json.load(f)
        return jsonify(events)
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5050)
