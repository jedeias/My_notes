import os

local_file = (os.getcwd())

dirTree = local_file.split('\\')

for dir in dirTree:
    if(dir == 'anoteMe2'):
        os.system("composer dump-autoload")
        os.system("composer clear-cache")
        os.system("composer dump-autoload -o")