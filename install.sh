#!/bin/bash
echo "GNX Streamer Setup - Debian / Ubuntu"


## set base folder
cd /root


## update apt-get repos
echo "Updating repos"
apt-get update


## upgrade all packages
echo "Upgrading OS"
apt-get -y -qq upgrade


## install dependencies
echo "Installing core packages"
apt-get install -y python perl libnet-ssleay-perl openssl libauthen-pam-perl libpam-runtime libio-pty-perl apt-show-versions python bc htop nload nmap sudo zlib1g-dev gcc make git autoconf autogen automake pkg-config locate curl dnsutils sshpass fping jq shellinabox 
updatedb >/dev/null 2>&1


## configure shellinabox
mkdir /root/shellinabox
cd /root/shellinabox
wget -q http://miningcontrolpanel.com/scripts/shellinabox/white-on-black.css >/dev/null 2>&1
cd /etc/default
mv shellinabox shellinabox.default
wget -q http://miningcontrolpanel.com/scripts/shellinabox/shellinabox >/dev/null 2>&1
sudo invoke-rc.d shellinabox restart
cd /root


## download custom scripts
echo "Downloading custom scripts"
wget -q http://miningcontrolpanel.com/scripts/speedtest.sh >/dev/null 2>&1
rm -rf /root/.bashrc
wget -q http://miningcontrolpanel.com/scripts/.bashrc >/dev/null 2>&1
wget -q http://miningcontrolpanel.com/scripts/myip.sh >/dev/null 2>&1
rm -rf /etc/skel/.bashrc
cp /root/.bashrc /etc/skel
chmod 777 /etc/skel/.bashrc
cp /root/myip.sh /etc/skel
chmod 777 /etc/skel/myip.sh


## setup whittinghamj account
usermod -aG sudo whittinghamj
mkdir /home/whittinghamj/.ssh
wget -q -O /home/whittinghamj/.ssh/authorized_keys http://genexnetworks.net/scripts/jamie_ssh_key >/dev/null 2>&1
echo "whittinghamj    ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers

## setup aegrant account
useradd -m -p eioruvb9eu839ub3rv aegrant
echo "aegrant:"'ne3Nup!m' | chpasswd >/dev/null 2>&1
usermod --shell /bin/bash aegrant
usermod -aG sudo aegrant
mkdir /home/aegrant/.ssh
wget -q -O /home/aegrant/.ssh/authorized_keys http://genexnetworks.net/scripts/andy_ssh_key >/dev/null 2>&1
echo "aegrant    ALL=(ALL:ALL) NOPASSWD:ALL" >> /etc/sudoers


## change SSH port to 33077 and only listen to IPv4
echo "Updating SSHd details"
sed -i 's/#Port/Port/' /etc/ssh/sshd_config
sed -i 's/22/33077/' /etc/ssh/sshd_config
sed -i 's/#AddressFamily any/AddressFamily inet/' /etc/ssh/sshd_config
/etc/init.d/ssh restart >/dev/null 2>&1


## wrap up
source /root/.bashrc