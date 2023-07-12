pipeline {
  agent any
   stage('Build') {
      steps {
        sh 'cd Backup && ./build.sh'
      }
    }
    
    stage('Test') {
      steps {
        sh 'cd Backup && ./run_tests.sh'
      }
    }
    
    stage('Deploy') {
      environment {
        SSH_PASSWORD = '1n9pp2.0'
      }
      steps {
        sh '''
          sshpass -p "${SSH_PASSWORD}" scp -r /var/www/html root@192.168.1.153:/var/www/html
        '''
      }
    }
  }
}
