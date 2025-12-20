FROM php:8.2-cli

# Install useful development tools
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Set the working directory
WORKDIR /workspace

# Expose port 8080 for the PHP built-in server
EXPOSE 8080

# Default command
CMD ["bash"]
