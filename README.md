1. Open CMD
2. Go to XAMPP PHP folder
cd C:\xampp\php
3 Download composer.phar
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
4. Verify the installer (optional but recommended)
php -r "if (hash_file('sha384', 'composer-setup.php') === file_get_contents('https://composer.github.io/installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
5. Install Composer
php composer-setup.php
You’ll see: Composer successfully installed to: C:\xampp\php\composer.phar
6. Delete installer
php -r "unlink('composer-setup.php');"



🛠 Optional: Make composer global (usable anywhere)
Move composer.phar to a global folder, example:
move composer.phar C:\xampp\php\composer.phar
Open Notepad and paste: @php "C:\xampp\php\composer.phar" %*


C:\xampp\php\php.ini
extension=gd
extension=zip
