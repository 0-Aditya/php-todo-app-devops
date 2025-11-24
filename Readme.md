📦 DevOps CI/CD Pipeline — PHP Todo App

End-to-End DevOps Project using GitHub, Jenkins, Docker, DockerHub, AWS EC2, Prometheus & Grafana

🚀 Project Overview

This project demonstrates a complete DevOps workflow implemented fully on AWS Free Tier resources.

It includes:

Continuous Integration using GitHub + Jenkins

Containerization using Docker

Image Registry using DockerHub

Deployment on AWS EC2

Monitoring using Prometheus + Grafana

Two-Server Architecture

Automated build → push → deploy workflow

Due to free-tier RAM limitations, tools like Kubernetes, SonarQube, and ArgoCD were intentionally skipped (they require 4–8 GB RAM).
Instead, this project focuses on building a complete and fully functional CI/CD + Monitoring pipeline that works reliably on free-tier hardware.

🏗️ Architecture Diagram
               +-----------------------+
               |       GitHub Repo     |
               +-----------+-----------+
                           |
                           | (Webhook / Poll SCM)
                           v
                  +--------+--------+
                  |     Jenkins     |
                  |  Build & Push   |
                  +--------+--------+
                           |
                           | (DockerHub Push)
                           v
                 +---------+---------+
                 |     DockerHub     |
                 +---------+---------+
                           |
                           | (docker pull)
                           v
         +-----------------+------------------+
         |               EC2 #1               |
         |      Production App Server        |
         |  PHP Todo App inside Docker       |
         +-----------------+------------------+
                           |
                           | (9100 metrics)
                           v
         +-----------------+------------------+
         |               EC2 #2               |
         |      Monitoring Server            |
         | Prometheus + Grafana + NodeExp    |
         +------------------------------------+

🧩 Technologies Used
Category	Tools
Version Control	GitHub
CI/CD	Jenkins, Jenkinsfile
Containerization	Docker
Image Hosting	DockerHub
Cloud Hosting	AWS EC2
Monitoring	Prometheus, Grafana, Node Exporter
OS	Ubuntu 22.04 LTS
App	PHP 8.1 + Apache
📁 Repository Structure
.
├── Dockerfile
├── Jenkinsfile
├── app/
├── config/
└── public/
    └── index.php

🐳 Docker Setup
Build the image
docker build -t todoapp:v1 .

Run the container
docker run -d -p 80:80 --name todoapp todoapp:v1

🔧 Jenkins CI/CD Pipeline

Jenkins performs the following steps automatically:

1️⃣ Checkout code from GitHub
2️⃣ Build Docker image
3️⃣ Login to DockerHub
4️⃣ Push image
5️⃣ Notify success

Pipeline Overview (Jenkinsfile)
pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git 'https://github.com/<your-username>/<your-repo>.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t <dockerhub-username>/todo-app:latest .'
            }
        }

        stage('Login to DockerHub') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'dockerhub-creds',
                    usernameVariable: 'USER', passwordVariable: 'PASS')]) {
                        sh 'echo $PASS | docker login -u $USER --password-stdin'
                }
            }
        }

        stage('Push Image') {
            steps {
                sh 'docker push <dockerhub-username>/todo-app:latest'
            }
        }

        stage('Success') {
            steps {
                echo 'Pipeline executed successfully!'
            }
        }
    }
}

☁️ AWS EC2 Deployment

On the EC2 app server:

sudo docker pull <dockerhub-username>/todo-app:latest
sudo docker stop todoapp || true
sudo docker rm todoapp || true
sudo docker run -d -p 80:80 --name todoapp <dockerhub-username>/todo-app:latest

📊 Monitoring Stack (Prometheus + Grafana)

This project includes a dedicated monitoring server.

Tools Installed:

Node Exporter (on both servers)

Prometheus (port 9090)

Grafana (port 3000)

Official Node Exporter Dashboard (ID: 1860)

Prometheus scrape config:
scrape_configs:
  - job_name: "monitoring-server"
    static_configs:
      - targets: ["localhost:9100"]

  - job_name: "app-server"
    static_configs:
      - targets: ["<APP-SERVER-IP>:9100"]

⚠️ Why Kubernetes, SonarQube & ArgoCD Were Skipped

These tools cannot run on AWS t3.micro free tier:

Tool	Min RAM Needed	Free Tier Has
SonarQube	4 GB	1 GB
Kubernetes (kubeadm)	2 GB per node	1 GB
ArgoCD	Needs Kubernetes	N/A

Instead of unstable setups, this project focuses on a fully working pipeline achievable on free-tier hardware.

🏁 Final Results

This project successfully delivers:

✔ CI via Jenkins

✔ CD via DockerHub + EC2

✔ Dockerized PHP App

✔ Prometheus Infrastructure Monitoring

✔ Grafana Dashboards

✔ 2-Server Architecture

✔ Fully working free-tier DevOps system

🎉 Conclusion

This repository demonstrates a complete, deployable DevOps pipeline built within free-tier cloud limits—showcasing real CI/CD, automation, containerization, deployment, and monitoring.
