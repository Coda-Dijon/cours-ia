FROM node:22-slim

# Install useful dev tools for students
RUN apt-get update && apt-get install -y \
    git \
    curl \
    php-cli \
    && rm -rf /var/lib/apt/lists/*

# Install GitHub Copilot CLI globally
RUN npm install -g @github/copilot

# Working directory where student files will be mounted
WORKDIR /workspace

# Default entrypoint: interactive Copilot CLI session
ENTRYPOINT ["copilot"]
