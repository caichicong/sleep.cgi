# 安装 # 

需要安装MING扩展用来生成swf文件 
http://www.php.net/manual/en/book.ming.php

# 参数说明 #

type : 可选值为 html, js, css, swf, gif, png, jpg

sleep : 响应延迟多少秒, 默认为0

expires : 默认值为0

          -1  返回一个过时的expires头，避免组件被缓存

          0    不返回expires头

          1    返回一个未来的expires

last : 默认值为0

          -1  返回一个last-modified头

          0   不返回

width : 图片宽度

height : 图片高度

fcolor : 图片文字颜色 格式 fff 或 ffffff

bgcolor : 图片背景颜色 格式 fff 或 ffffff

# 例子 #

    sleep.php?type=gif&width=200&height=100&fcolor=fff&bgcolor=000&last=1

# Todo #

增加一个参数配置工具
