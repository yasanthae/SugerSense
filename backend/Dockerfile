# Backend Dockerfile

FROM python:3.9

# Set the working directory
WORKDIR /app

# Copy the backend files, including the CSV file, into the container
COPY ./backend /app

# Install required Python packages
RUN pip install -r requirements.txt

# Expose the Flask port
EXPOSE 5000

# Run the Flask app
CMD ["python", "app.py"]
