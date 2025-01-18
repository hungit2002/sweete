pipeline {
    agent any
    stages {
        stage('Clone stage') {
            steps {
                git 'https://github.com/hungit2002/sweete.git'
            }
        }
        stage('Build stage') {
            steps {
                // This step should not normally be used in your script. Consult the inline help for details.
                withDockerRegistry(credentialsId: 'docker-hub', url: 'https://index.docker.io/v1/') {
                    sh 'docker build -t hungit2002/laravel-sweete .'
                    sh 'docker push hungit2002/laravel-sweete'
                }
            }
        }
        stage('SSH Server') {
            steps {
                sshagent(['ssh-remote']) {
                    sh 'ssh -o StrictHostKeyChecking=no -l root 45.77.250.80 touch test.txt'
                }
            }
        }
    }
}
