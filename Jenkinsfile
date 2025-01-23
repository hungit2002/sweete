pipeline {
    agent { label 'laravel-agent' }  // Chỉ định node agent có tên là 'docker-agent', có thể là bất kỳ agent nào của bạn

    environment {
        // Đặt biến môi trường cho Docker image name, version, v.v.
        IMAGE_NAME = 'sweete-img'
        IMAGE_TAG = 'latest'
        DOCKER_REGISTRY = 'docker.io'  // Hoặc registry của bạn, ví dụ: Docker Hub, quay.io, v.v.
    }

    stages {
        stage('Clone Source') {
            steps {
                script {
                    // Clone repository từ GitHub
                    git branch: 'master', url: 'https://github.com/hungit2002/sweete.git'
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    // Xây dựng Docker image
                    sh 'docker build -t $IMAGE_NAME:$IMAGE_TAG .'
                }
            }
        }

        stage('Push Docker Image') {
            steps {
                script {
                    withDockerRegistry(credentialsId: 'docker-hub', url: 'https://index.docker.io/v1/') {
                        sh 'docker push $IMAGE_NAME:$IMAGE_TAG'
                    }
                }
            }
        }
    }

    post {
        success {
            echo 'Build and Push Docker image successfully!'
        }
        failure {
            echo 'Build failed.'
        }
    }
}
