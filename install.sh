#!/bin/bash

echo "Adding write permissions for apache in the following directories:"

echo "  - 'templates_compiled'"
setfacl -m u:apache:rwx templates_compiled/

echo "  - 'cache'"
setfacl -m u:apache:rwx cache/

exit 0
