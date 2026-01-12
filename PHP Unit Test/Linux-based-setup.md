# One time setup per pc if not done yet
    1) install WSL2
    2) install php , mysql inside wsl


--------------------
# install php , mysql inside wsl

✅ Correct this first (very important)
### 1️⃣ Move to Linux home directory
      cd ~
      pwd
### You should see:
    /home/ridwan

### 2️⃣ Create a proper workspace
    mkdir -p ~/projects/wp-plugins
    cd ~/projects/wp-plugins


✔ This is where all plugin work + tests should live

### 3️⃣ Now install packages (what you started is correct)
Run from anywhere (directory doesn’t matter):

    sudo apt update
    sudo apt install -y php php-cli php-xml php-mbstring php-mysql curl git unzip


When it asks:

[sudo] password for ridwan:


👉 Enter your Ubuntu user password
(This is the password you set when Ubuntu was first installed — not Windows password.)

Nothing will show while typing — this is normal.

### 4️⃣ Verify installation (inside WSL)

After install finishes:

    php -v

Expected:

PHP 8.x.x (cli)

### 5️⃣ Install & start MySQL (next step)
    sudo apt install -y mysql-server
    sudo service mysql start


Verify:

    mysql --version
