pipeline {
    agent any

    environment {
        DOCKERHUB_CREDENTIALS = 'dockerhub'   // Jenkins credential ID you created
        IMAGE_NAME = 'shinchan00/todo-app'       // <-- Replace with your Docker Hub repo
        IMAGE_TAG = "latest"
    }

    stages {
        stage('Clone Repository') {
            steps {
                git branch: 'main', url: 'https://github.com/0-Aditya/php-todo-app-devops.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    sh """
                        docker build -t ${IMAGE_NAME}:${IMAGE_TAG} .
                    """
                }
            }
        }

        stage('Login to Docker Hub') {
            steps {
                script {
                    withCredentials([usernamePassword(credentialsId: DOCKERHUB_CREDENTIALS, usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                        sh """
                            echo "$DOCKER_PASS" | docker login -u "$DOCKER_USER" --password-stdin
                        """
                    }
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                script {
                    sh """
                        docker push ${IMAGE_NAME}:${IMAGE_TAG}
                    """
                }
            }
        }
    }
}
