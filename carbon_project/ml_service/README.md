# ML Service (Random Forest)

This small Python Flask service trains and serves a Random Forest classifier to predict `Low Impact`, `Medium Impact`, or `High Impact` based on features.

Setup

```bash
python -m venv venv
venv\Scripts\activate    # Windows
pip install -r requirements.txt
python train.py
python app.py
```

By default the service listens on port `5000` and exposes `POST /predict` with JSON body:

```json
{
  "travel_km": 10,
  "electricity_units": 20,
  "food_score": 5,
  "water_liters": 50,
  "carbon_value": 12.5
}
```

Response example:

```json
{ "label": "Medium Impact" }
```

Integration notes:
- Set `ML_SERVICE_URL` in your Laravel `.env` to point to the running ML service, e.g. `http://127.0.0.1:5000`.
- The Laravel controller will POST `{ travel_km, electricity_units, food_score, water_liters, carbon_value }` to `/predict` and expects `{ "label": "Low Impact" }`.
- The app stores the ML output in `ml_prediction`; `impact_level` continues to store rule-based classification.
- If the ML service is unavailable, the app falls back to threshold-based impacts and stores that fallback in `ml_prediction`.

