# 1. ベースとなるイメージを指定（これが無いとエラーになりますぞ！）
FROM litespeedtech/openlitespeed:1.8.2-lsphp83

# 2. Composer をコピー（これが「魔法の1行」でござる）
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. 念のため作業ディレクトリを指定
WORKDIR /var/www/vhosts/localhost/html
