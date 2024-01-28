FROM nginx:alpine

COPY .docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

RUN echo "upstream php-upstream { server app:9000; }" > /etc/nginx/conf.d/upstream.conf

COPY . /var/www

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
