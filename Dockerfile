FROM ten7/flight-deck-web:develop-drupal7
MAINTAINER tess@ten7.com

# Switch to root for the build.
USER root

# Override some Ansible defaults.
ENV ANSIBLE_ROLES_PATH /ansible/roles
ENV ANSIBLE_NOCOWS 1

# Copy the files needed by the site.
COPY --chown=apache:apache ansible /ansible
COPY --chown=apache:apache src /var/www/html

# Build the site.
#
# We need to reinvoke setcap to ensure HTTPD can run as non-root.
RUN setcap cap_net_bind_service=+ep /usr/sbin/httpd && \
    ansible-galaxy install -fr /ansible/requirements.yml && \
    ansible-playbook -i /ansible/inventories/all.ini /ansible/build.yml

# Switch back to apache for runtime.
USER apache

# Only expose 80, as HTTPS is terminiated in the ingress.
EXPOSE 80
