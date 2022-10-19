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

#port = 5000
ThreadCount = 0
url = str(settt[0])
port=int(settt[1])
key=settt[2]
#host = socket.getho
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
            print(f'cmd: {cmd}')
            x = cmd.split("(90)")
            i=1
            for y in x:
                message= str(y)
                message= message.replace(' ','')
                message= message.replace('\n','')
                message= message.replace('\t','')
                message= message.replace('\r','')
                message = message.strip('\n')
                message = message.strip('\t')            
                message = message.strip('\r')  
                if len(message) >=5:          
                    i+=1
                    url1=url+"?status=(90)"+str(message)+"&key="+str(key)
                    response2 = request.urlopen(url1)
                    print (str(i)+" "+ url1)
           
    print(f'disconnect: {a}')