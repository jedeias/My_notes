import os

local_file = (os.getcwd())

dirTree = local_file.split('\\')

for dir in dirTree:
    if(dir == 'My_notes'):
        os.system("composer dump-autoload")
        os.system("composer clear-cache")
        os.system("composer dump-autoload -o")
        print("Autoload files refreshed.")