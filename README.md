# CoolPBX Templates
Templates used by CoolPBX 2. CoolPBX 2 will use these templates when installing from zero or when you need to rebuild something.

The app2yaml.php script converts the complex PHP arrays from FusionPBX into a simple, easy-to-update YAML format. 
## The YAML Script
```sh
wget -O https://raw.githubusercontent.com/CoolPBX/Templates/refs/heads/main/app2yaml.php
php papp2yaml.php --directory /var/www/fusionpbx --type={vendors,permissions,settings,menu} 2>/dev/null >anyname.yaml
```
