pipeline {
    agent any
    stages {
        stage('Clone stage') {
            steps {
                git 'https://github.com/hungit2002/sweete.git'
            }
        }
        stage('Build Image') {
            steps {
                withDockerRegistry(credentialsId: 'docker-hub', url: 'https://index.docker.io/v1/') {
                    sh 'docker build -t hungit2002/laravel-sweete .'
                }
            }
        }
    }
}
