查看系统版本 hostnamectl
上传下载 yum install -y lrzsz
netstat yum install net-tools


安装python3.6(不要装高版本，不稳定)
解压tgz tar zxvf Python-3.6.12.tgz
yum install gcc
yum install libffi-devel -y
yum -y install zlib* 
yum install openssl-devel -y

yum install python-setuptools


./configure --with-ssl
make& make install

//更改软连接
ln -sf /usr/local/bin/python3.6 /usr/bin/python
查看
ll /usr/bin/python
更改yum等 python
vi /user/bin/yum
vi /usr/libexec/urlgrabber-ext-down
/usr/bin/python2.7

pip3 install Django

Django Nginx+uwsgi 安装配置
yum groupinstall "Development tools"
yum install zlib-devel bzip2-devel pcre-devel openssl-devel ncurses-devel sqlite-devel readline-devel tk-devel

——————————————
Nginx
wget -c https://nginx.org/download/nginx-1.12.0.tar.gz
tar -zxvf nginx-1.12.0.tar.gz
cd nginx-1.12.0
./configure
make && make install
cd /usr/local/nginx/sbin
./nginx
————————————————
开防火墙
firewall-cmd --zone=public --add-port=80/tcp --permanent
firewall-cmd --reload
————————————————
开机自启
vim /etc/rc.d/rc.local
