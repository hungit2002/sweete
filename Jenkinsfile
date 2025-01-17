pipeline {
    agent any
    environment {
        APP_ENV = "production"
        DEPLOY_SERVER = "root@45.77.250.80"
        DEPLOY_PATH = "/var/www"
    }
    stages {
        stage('Clone') {
            steps {
                git 'https://github.com/hungit2002/sweete.git'
            }
        }
        stage('Deploy to Server') {
            steps {
                sshagent(['ssh-sweete-deploy-key']) {
                    sh """
                        rsync -avz --exclude=".git" --exclude="node_modules" \
                        --exclude="storage" --exclude=".env" ./ ${DEPLOY_SERVER}:${DEPLOY_PATH}
                        ssh ${DEPLOY_SERVER} "
                            cd ${DEPLOY_PATH} &&
                            composer install --no-dev --optimize-autoloader &&
                            php artisan migrate --force &&
                            php artisan cache:clear &&
                            php artisan config:cache
                        "
                    """
                }
            }
        }
    }
     post {
            success {
                echo 'Deployment successful!'
            }
            failure {
                echo 'Deployment failed.'
            }
            always {
                cleanWs()
            }
        }
}
