from flask import Flask, request, jsonify
import joblib
import os
import numpy as np

app = Flask(__name__)

MODEL_PATH = os.path.join(os.path.dirname(__file__), 'model.pkl')
# Fallback to project root if model stored there
if not os.path.exists(MODEL_PATH):
    MODEL_PATH = os.path.join(os.path.dirname(__file__), '..', 'model.pkl')
MODEL_PATH = os.path.abspath(MODEL_PATH)
model = None

def load_model():
    global model
    if model is None:
        model = joblib.load(MODEL_PATH)
    return model


@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json(force=True)
    try:
        features = [
            float(data.get('travel_km', 0)),
            float(data.get('electricity_units', 0)),
            float(data.get('food_score', 0)),
            float(data.get('water_liters', data.get('water_usage', 0))),
            float(data.get('carbon_value', 0)),
        ]
        clf = load_model()
        pred = clf.predict([features])[0]
        return jsonify({'label': str(pred)})
    except Exception as e:
        return jsonify({'error': str(e)}), 400


if __name__ == '__main__':
    # If model doesn't exist, instruct user to run train.py
    if not os.path.exists(MODEL_PATH):
        print('Model not found. Run python train.py to create model.pkl')
    app.run(host='0.0.0.0', port=5000)
