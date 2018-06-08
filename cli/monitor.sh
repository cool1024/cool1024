#!/bin/bash
#这个脚本使用来统计CPU、磁盘、内存使用率、带宽的
total=0
system=0
user=0
i=0

time=`date "+%Y-%m-%d %k:%M"`
day=`date "+%Y-%m-%d"`
minute=`date "+%k:%M"`
echo  "******" >> test.txt
echo "统计开始时间：$day $minute" >> test.txt

#带宽使用情况
echo "#带宽的使用情况：#" >>test.txt
#循环五次，避免看到的是偶然的数据
while (( $i<5 ))
do
rx_before=$(cat /proc/net/dev | grep 'enp' | tr : " " | awk '{print $2}')
tx_before=$(cat /proc/net/dev | grep 'enp' | tr : " " | awk '{print $10}')
sleep 2
#用sed先获取第7列,再用awk获取第2列，再cut切割,从第7个到最后，即只切割网卡流量数字部分
rx_after=$(cat /proc/net/dev | grep 'enp' | tr : " " | awk '{print $2}')
tx_after=$(cat /proc/net/dev | grep 'enp' | tr : " " | awk '{print $10}')
#注意下面截取的相差2秒的两个时刻的累计和发送的bytes(即累计传送和接收的位)
rx_result=$[(rx_after-rx_before)/1024/1024/2*8]
tx_result=$[(tx_after-tx_before)/1024/1024/2*8]
echo  "$time Now_In_Speed: $rx_result Mbps Now_OUt_Speed: $tx_result Mbps" >>test.txt
let "i++"
done
#注意下面grep后面的$time变量要用双引号括起来
rx_result=$(cat test.txt|grep "$time"|awk '{In+=$4}END{print In}')
tx_result=$(cat test.txt|grep "$time"|awk '{Out+=$7}END{print Out}')
In_Speed=$(echo "scale=2;$rx_result/5"|bc)
Out_Speed=$(echo "scale=2;$tx_result/5"|bc)
#echo "#带宽的5次的平均值是：#" >>test.txt
echo  "$time In_Speed_average: $In_Speed Mbps Out_Speed_average: $Out_Speed Mbps" >>test.txt

#CPU使用情况
#使用vmstat 1 5命令统计5秒内的使用情况，再计算每秒使用情况
which sar > /dev/null 2>&1
if [ $? -ne 0 ]
then
total=`vmstat 1 5|awk '{x+=$13;y+=$14}END{print x+y}'`
average=$(echo "scale=2;$total/5"|bc)
fi
echo "#CPU使用率:#" >>test.txt
echo "Total CPU  is already use: $average%" >>test.txt


#磁盘使用情况(注意：需要用sed先进行格式化才能进行累加处理)
disk_used=$(df -m | sed '1d;/ /!N;s/\n//;s/ \+/ /;' | awk '{used+=$3} END{print used}')
disk_totalSpace=$(df -m | sed '1d;/ /!N;s/\n//;s/ \+/ /;' | awk '{totalSpace+=$2} END{print totalSpace}')
disk_all=$(echo "scale=4;$disk_used/$disk_totalSpace" | bc)
disk_percent1=$(echo $disk_all | cut -c 2-3)
disk_percent2=$(echo $disk_all | cut -c 4-5)
disk_warning=`df -m | sed '1d;/ /!N;s/\n//;s/ \+/ /;' | awk '{if ($5>85) print $5 $6;} '`
echo "#磁盘利用率#" >>test.txt
echo "hard disk has used: $disk_percent1.$disk_percent2%" >>test.txt
#echo -e "\t\t.." 表示换行
echo -e "\t\t#磁盘存在目录使用率超过85%报警#" >>test.txt
echo -e "\t\tover used: $disk_warning" >>test.txt


#内存使用情况
#获得系统总内存
memery_all=$(free -m | awk 'NR==2' | awk '{print $2}')
#获得占用内存（操作系统 角度）
system _memery_used =$(free -m | awk 'NR==2' | awk '{print $3}')
#获得buffer、cache占用内存，当内存不够时会及时回收，所以这两部分可用于可用内存的计算
buffer_used=$(free -m | awk 'NR==2' | awk '{print $6}')
cache_used=$(free -m | awk 'NR==2' | awk '{print $7}')
#获得被使用内存，所以这部分可用于可用内存的计算，注意计算方法
actual_used_all =$[memery_all-(free+buffer_used+cache_used)]
#获得实际占用的内存
actual_used_all=`expr $memery_all - $free + $buffer_used + $cache_used `
echo "$used_all" >> test.txt
memery_percent=$(echo "scale=4;$system _memery_used / $memery_all" | bc)
memery_percent2=$(echo "scale=4; $actual_used_all / $memery_all" | bc)
percent_part1=$(echo $memery_percent | cut -c 2-3)
percent_part2=$(echo $memery_percent | cut -c 4-5)
percent_part11=$(echo $memery_percent2 | cut -c 2-3)
percent_part22=$(echo $memery_percent2 | cut -c 4-5)
echo "#内存使用率#" >> test.txt
#获得占用内存（操作系统角度）
echo "system memery is already use: $percent_part1.$percent_part2%" >>test.txt
#获得实际内存占用率
echo "actual memery is already use: $percent_part11.$percent_part22%" >>test.txt
echo "buffer is already used : $buffer_used M" >>test.txt
echo "cache is already used : $cache_used M" >>test.txt

echo  "结束本次统计：$day $minute" >> test.txt
