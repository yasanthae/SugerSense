# Use the official Nginx image as a base
FROM nginx:alpine

# Set the directory in the container where files will be copied
WORKDIR /usr/share/nginx/html

# Remove the default Nginx index file
RUN rm -rf ./*

# Copy the HTML file into the Nginx directory
COPY index.html .

# Expose port 80 (inside the container)
EXPOSE 80

# Start Nginx server
CMD ["nginx", "-g", "daemon off;"]
