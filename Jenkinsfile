pipeline {
    agent none
    stages {
        stage('Clone stage') {
            agent { label 'jenkin-node' }
            steps {
                git 'https://github.com/hungit2002/sweete.git'
            }
        }
        stage('Prepare env') {
            agent { label 'jenkin-node' }
            steps {
                script {
                    def envFile = 'env-sweete-live'
                    // Sao chép file .env từ Jenkins server đến thư mục làm việc
                    sh "cp /var/jenkins_home/envs/${envFile} .env"
                }
            }
        }
        stage('Build Image') {
            agent { label 'jenkin-node' }
            steps {
                // This step should not normally be used in your script. Consult the inline help for details.
                withDockerRegistry(credentialsId: 'docker-hub', url: 'https://index.docker.io/v1/') {
                    sh 'docker build -t hungit2002/laravel-sweete .'
                }
            }
        }
        stage('Push image') {
            agent { label 'jenkin-node' }
            steps {
                // This step should not normally be used in your script. Consult the inline help for details.
                withDockerRegistry(credentialsId: 'docker-hub', url: 'https://index.docker.io/v1/') {
                    sh 'docker push hungit2002/laravel-sweete'
                }
            }
        }
        stage('Deploy image') {
            agent { label 'sweete_server' }
            steps {
               sshagent(['ssh-remote']) {
                   sh 'ssh -o StrictHostKeyChecking=no -l root 45.77.250.80 docker pull hungit2002/laravel-sweete && docker-compose up -d'
               }
            }
        }
    }
}
