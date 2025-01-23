pipeline {
    agent none
    stages {
        stage('Clone stage') {
            agent { label '	laravel-agent' }
            steps {
                git 'https://github.com/hungit2002/sweete.git'
            }
        }
    }
}
