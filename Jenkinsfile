pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo 'Iniciando Build...'
                sh 'composer install -d ./RENAPSys'
                sh 'mv ./RENAPSys/.env.example ./RENAPSys/.env'
                sh 'php ./RENAPSys/artisan key:generate'
            }
        }
        stage('Test') {
            steps {
                echo 'Realizando pruebas...'
            }
        }
        stage('Deploy') {
            steps {
                echo 'Despliegue...'
                sh 'rm -r /var/www/html/RENAPSys'
                sh 'cp -r ./RENAPSys /var/www/html/'
                sh 'sudo kill $(sudo lsof -t -i:9000)'
                sh 'php /var/www/html/RENAPSys/artisan serve --host 0.0.0.0 --port 9000'
            }
        }
    }
}
