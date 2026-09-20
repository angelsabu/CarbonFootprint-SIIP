# Project Scope & Deliverables

Project: Carbon Footprint Tracking and Sustainability Recommendation System

Purpose
- Track daily carbon footprint from travel, electricity, food and water.
- Classify users into impact groups (Low / Medium / High) using a Random Forest classifier.
- Provide actionable sustainability recommendations and reports.

Core Deliverables
1. Backend (Laravel)
   - Models, controllers and migrations for `footprints` with fields: travel_km, electricity_units, food_score, water_usage, carbon_value, impact_level, notes, recommendation
   - Validation via FormRequest classes for store/update flows
   - CSV export and filtered listing with pagination
   - Simple recommendation engine (rule-based, ML-informed)

2. Machine Learning Service (Python Flask)
   - Synthetic dataset generator and training script (`ml_service/train.py`)
   - Random Forest model saved as `model.pkl`
   - Flask API `POST /predict` returning `{ "label": "Low Impact" }`
   - Integration instructions and `.env` variable `ML_SERVICE_URL`

3. UI / UX
   - Bootstrap 5 responsive dashboard with summary cards and a clear table of footprints
   - Forms for adding/editing footprints including water and notes

4. Testing & QA
   - Integration test to verify ML integration (tests/Feature/FootprintMlIntegrationTest.php)
   - Unit/feature tests for controllers and model (to be completed)

5. Documentation & Deployment
   - README and ML service README with setup steps
   - Dockerization and deployment guide (to be completed)

Timeline (suggested)
- Phase 1 (1-2 days): Finish DB, validation, dashboard polish, CSV export
- Phase 2 (1-2 days): Train ML model, run Flask service, integrate with controller
- Phase 3 (1-2 days): Tests, documentation, final polish and packaging

Next immediate actions
- Train the ML model (run `ml_service/train.py`) and start the Flask service
- Add/execute integration tests and extend unit tests
