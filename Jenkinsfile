pipeline {
    agent any
    stages {
        stage('Deploy image') {
            steps {
               sshagent(['ssh-remote']) {
                   sh 'docker-compose up -d'
               }
            }
        }
    }
}
