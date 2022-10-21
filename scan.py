#! C:/python/python.exe 
from socket import *
from urllib import request
file1 = open('setting2.txt', 'r')
Lines = file1.readlines()
print("Content-Type: text/html\n")

count = 0
settt=[]
# Strips the newline character
for line in Lines:
    count += 1
    settt.append(line.strip())    #print("Line{}: {}".format(count, line.strip()))

ThreadCount = 0
url = str(settt[0])
port=int(settt[1])
key=settt[2]
host =str(settt[3])
s = socket()
s.bind((host,port))
s.listen(1)
while True:
    c,a = s.accept()
    print(f'connect: {a}')
    read  = c.makefile('r')
    write = c.makefile('w')
    with c,read,write:
        while True:
            data = read.readline()
            if not data: break
            cmd = data.strip()
            print(f'data: {cmd}')
            url1=url+"?barcode="+str(cmd)+"&key="+str(key)
            print(f'sent to server {url1}')
            response2 = request.urlopen(url1)
           
    print(f'disconnect: {a}')