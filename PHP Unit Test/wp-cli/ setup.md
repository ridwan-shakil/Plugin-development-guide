# setup wp-cli globally (One time setup per pc) 
Doc: https://make.wordpress.org/cli/handbook/guides/installing/#installing-via-composer

NOTE: use cmd OR powershell , Git may not recognize those commands 

--------------------------------------
## Installing on Windows :
        
        Install via composer as described above or use the following method.
        
        Make sure you have php installed and in your path so you can execute it globally.
        
        Download wp-cli.phar manually and save it to a folder, for example c:\wp-cli
        
        Create a file named wp.bat in c:\wp-cli with the following contents:

                @ECHO OFF
                php "c:/wp-cli/wp-cli.phar" %*

        Add c:\wp-cli to your path:

----------------------------
## Steps to add C:\wp-cli to PATH (Windows 11)
        
        Open Environment Variables
        
        Press Start → type environment variables → click “Edit the system environment variables”.
        
        In the System Properties window, click Environment Variables… at the bottom.
        
        Edit your PATH
        
        In the User variables section (top half), find Path → select it → click Edit….
        
        (You can also add it to “System variables” if you want it available for all users, but “User variables” is enough.)
        
        Add new entry
        
        Click New → paste:
        
        C:\wp-cli
        D:\Xampp\mysql\bin     ## Mysql is also needed
        
        Click OK to save.
        
        Restart your terminal
        
        Close any open Command Prompt / PowerShell / Git Bash windows.

Open a new one and type:

        wp --info
        wp --version


If everything’s correct, you should now see WP-CLI info and version output. 🎉
