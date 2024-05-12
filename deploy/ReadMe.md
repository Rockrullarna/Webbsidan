Bing CoPilot-svar för en deploy: 

Certainly! To deploy your files to a server using GitHub Actions and SFTP, you can use the **SFTP Deploy** action. This action allows you to transfer files securely via SSH Private Key. Here's how you can set it up:

1. **Create a Workflow File** (e.g., `.github/workflows/deploy.yml`) in your repository with the following content:

    ```yaml
    name: Deploy via SFTP

    on:
      push:
        branches:
          - main

    jobs:
      deploy:
        runs-on: ubuntu-latest
        steps:
          - name: Checkout
            uses: actions/checkout@v2

          - name: Deploy files
            uses: wlixcc/SFTP-Deploy-Action@v1.2.4
            with:
              username: 'your_ssh_username'
              server: 'your_server_ip'
              ssh_private_key: ${{ secrets.SSH_PRIVATE_KEY }}
              local_path: './static/*'  # Specify the path to your files
              remote_path: '/var/www/app'
              sftpArgs: '-o ConnectTimeout=5'
    ```

    Replace `'your_ssh_username'`, `'your_server_ip'`, and the paths as needed. Make sure you have set up the necessary secrets for `SSH_PRIVATE_KEY`.

2. **Note on SSH Key Format**:

    If you use the Ed25519 algorithm to generate an SSH key pair (using `ssh-keygen -t ed25519 -C "your_email@example.com"`), ensure that the last line of the private key is a blank line. Keep this line when adding Repository secrets to avoid an invalid format error¹.

Remember to adjust the paths, usernames, and server details according to your project. Happy deploying! 🚀🔑

For more details, you can find the **SFTP Deploy** action on the [GitHub Marketplace](https://github.com/marketplace/actions/sftp-deploy).¹

Källa: Konversation med Bing, 2024-05-12
(1) SFTP Deploy · Actions · GitHub Marketplace · GitHub. https://github.com/marketplace/actions/sftp-deploy.
(2) sftp-deploy · GitHub Topics · GitHub. https://github.com/topics/sftp-deploy.
(3) sftp-deploy-action · Actions · GitHub Marketplace · GitHub. https://github.com/marketplace/actions/sftp-deploy-action.
(4) FTP/SFTP file deployer · Actions · GitHub Marketplace · GitHub. https://github.com/marketplace/actions/ftp-sftp-file-deployer.
(5) SSH & SFTP Deploy · Actions · GitHub Marketplace · GitHub. https://github.com/marketplace/actions/ssh-sftp-deploy.
(6) How to SFTP with Github Actions? - Stack Overflow. https://stackoverflow.com/questions/63697142/how-to-sftp-with-github-actions.
(7) undefined. https://github.com/marketplace/actions/ftp-deploy.