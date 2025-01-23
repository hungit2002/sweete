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
                // This step should not normally be used in your script. Consult the inline help for details.
                withDockerRegistry(credentialsId: 'docker-hub', url: 'https://index.docker.io/v1/') {
                    sh 'docker build -t hungit2002/laravel-sweete .'
                }
            }
        }
        stage('Push image') {
            steps {
                // This step should not normally be used in your script. Consult the inline help for details.
                withDockerRegistry(credentialsId: 'docker-hub', url: 'https://index.docker.io/v1/') {
                    sh 'docker push hungit2002/laravel-sweete'
                }
            }
        }
        stage('Deploy image') {
            steps {
                sshagent(['ssh-remote']) {
                    sh '''
                    ssh -o StrictHostKeyChecking=no -l root 45.77.250.80 <<'EOF'
                    mkdir -p /root/sweete_2
                    cat << 'EOC' > /root/sweete_2/docker-compose.yml
                    version: '3.7'
                    services:
                      sweete:
                        build:
                          context: ./
                          dockerfile: Dockerfile
                        image: sweete-img
                        container_name: sweete-container
                        restart: unless-stopped
                        working_dir: /var/www/
                        ports:
                          - '8000:9000'
                        volumes:
                          - ./:/var/www/
                        networks:
                          - app-network
                    networks:
                      app-network:
                        driver: bridge
                    EOC

                    cd /root/sweete_2
                    /snap/bin/docker-compose up -d
                    EOF
                    '''
                }
            }
        }
    }
}
