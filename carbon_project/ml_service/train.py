import os
import numpy as np
import pandas as pd
from sklearn.ensemble import RandomForestClassifier
from sklearn.model_selection import train_test_split
from sklearn.metrics import classification_report
import joblib

# Generate synthetic dataset
np.random.seed(42)
N = 1000
travel = np.random.gamma(2.0, 5.0, N)  # km
electricity = np.random.gamma(2.0, 3.0, N)  # units
food = np.random.normal(5.0, 2.0, N)
water = np.random.gamma(2.0, 25.0, N)  # liters

carbon = travel * 0.21 + electricity * 0.85 + food * 1.5 + water * 0.05

def label_from_carbon(c):
    if c < 5:
        return 'Low Impact'
    elif c <= 15:
        return 'Medium Impact'
    else:
        return 'High Impact'

labels = [label_from_carbon(c) for c in carbon]

df = pd.DataFrame({
    'travel_km': travel,
    'electricity_units': electricity,
    'food_score': food,
    'water_liters': water,
    'carbon_value': carbon,
    'label': labels,
})

X = df[['travel_km', 'electricity_units', 'food_score', 'water_liters', 'carbon_value']]
y = df['label']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

clf = RandomForestClassifier(n_estimators=100, random_state=42)
clf.fit(X_train, y_train)

pred = clf.predict(X_test)
print(classification_report(y_test, pred))

# Save model alongside the ML app
output_path = os.path.join(os.path.dirname(__file__), 'model.pkl')
joblib.dump(clf, output_path)
print(f'Model saved to {output_path}')
