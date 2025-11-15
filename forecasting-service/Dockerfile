# forecasting-service/Dockerfile
FROM python:3.11-slim-bookworm

# Install system dependencies + security updates
RUN apt-get update && \
    apt-get upgrade -y --no-install-recommends && \
    apt-get install -y --no-install-recommends curl && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /app
COPY requirements.txt .

# Install Python dependencies
RUN pip install --no-cache-dir --upgrade pip && \
    pip install --no-cache-dir -r requirements.txt

COPY . .

# Use 0.0.0.0 for Docker compatibility
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000"]