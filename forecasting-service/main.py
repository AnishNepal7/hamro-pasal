from fastapi import FastAPI
from pydantic import BaseModel
from typing import List
from datetime import date, timedelta
import pandas as pd
import numpy as np

FORECASTING_WINDOW_DAYS = 28
PROJECTION_DAYS = 7
MINIMUM_DATA_POINTS = 3

app = FastAPI(
    title="Hamro Pasal Forecasting Service",
    description="Provides dynamic sales & revenue forecasts using EMA with trend."
)

class SalesRecord(BaseModel):
    date: date
    quantity: float
    price: float = 0.0

class SalesData(BaseModel):
    sales: List[SalesRecord]


def compute_ema(values: List[float], span: int) -> float:
    clean = [float(v) for v in values if not (v is None or np.isnan(v))]
    if not clean:
        return 0.0
    alpha = 2.0 / (span + 1)
    ema = clean[0]
    for x in clean[1:]:
        ema = alpha * x + (1.0 - alpha) * ema
    return ema


def calculate_trend(values: List[float]):
    if len(values) < 2:
        return 0.0
    return ((values[-1] - values[0]) / values[0]) * 100 if values[0] != 0 else 0.0


def generate_7day_projection(base, trend_percent):
    daily_values = []
    current = base

    for _ in range(PROJECTION_DAYS):
        change = current * (trend_percent / 100)
        current = current + change
        daily_values.append(round(current, 2))

    return daily_values, round(sum(daily_values), 2)




# ================================
#       FORECAST SALES
# ================================
@app.post("/forecast/sales")
def forecast_sales(data: SalesData):

    df = pd.DataFrame([record.dict() for record in data.sales])
    df["date"] = pd.to_datetime(df["date"])
    df.set_index("date", inplace=True)
    df.sort_index(inplace=True)

    if len(df) < MINIMUM_DATA_POINTS:
        base = df["quantity"].mean() if not df.empty else 0.0
        trend = 0.0
    else:
        recent = df["quantity"].last(f"{FORECASTING_WINDOW_DAYS}D")
        values = [v for v in recent.tolist() if not pd.isna(v)]

        base = compute_ema(values, FORECASTING_WINDOW_DAYS)
        trend = calculate_trend(values)

    projection, weekly_total = generate_7day_projection(base, trend)

    return {
        "trend_percent": round(trend, 2),
        "next_7_days_sales": projection,
        "weekly_sales_forecast": weekly_total
    }





# ================================
#      FORECAST REVENUE
# ================================
@app.post("/forecast/revenue")
def forecast_revenue(data: SalesData):

    df = pd.DataFrame([record.dict() for record in data.sales])
    df["date"] = pd.to_datetime(df["date"])
    df.set_index("date", inplace=True)
    df.sort_index(inplace=True)

    df["quantity"] = pd.to_numeric(df["quantity"], errors="coerce").fillna(0)
    df["price"] = pd.to_numeric(df["price"], errors="coerce").fillna(0)
    df["revenue"] = df["quantity"] * df["price"]

    daily_revenue = df["revenue"].resample("D").sum()

    if len(daily_revenue) < MINIMUM_DATA_POINTS:
        base = daily_revenue.mean() if not daily_revenue.empty else 0.0
        trend = 0.0
    else:
        recent = daily_revenue.last(f"{FORECASTING_WINDOW_DAYS}D")
        values = [v for v in recent.tolist() if not pd.isna(v)]

        base = compute_ema(values, FORECASTING_WINDOW_DAYS)
        trend = calculate_trend(values)

    projection, weekly_total = generate_7day_projection(base, trend)

    return {
        "trend_percent": round(trend, 2),
        "next_7_days_revenue": projection,
        "weekly_revenue_forecast": weekly_total
    }
