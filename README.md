# smart-assist

收录一些高频 php 助手函数，提高工作效率。

### [ArrHelper](./src/ArrHelper.php)

| 调用方式 | 功能 |
|-------------|-------|
| `ArrHelper::same(array $arr1, array $arr2, bool $assoc = false): bool` | 检查两个数组元素是否相同。 |
| `ArrHelper::sortByField(array $array, string $key, int $sort = SORT_DESC, int $sortRule = SORT_NUMERIC): array` | 对数组根据指定字段进行排序。 |
| `ArrHelper::groupByField(array $array, string $key): array` | 对数组中指定字段的值进行分组。 |
| `ArrHelper::addDataToNestedArray(array $data, array $extraData): array` | 对二维数组增加同一项数据。 |
| `ArrHelper::minIntElement(array $data, string $key, bool $firstAs = true): array` | 找到二维数组中指定索引名值最小的元素。 |
| `ArrHelper::maxIntElement(array $data, string $key, bool $firstAs = true): array` | 找到二维数组中指定索引名值最大的元素。 |

### [CipherHelper](./src/CipherHelper.php)

| 调用方式 | 功能 |
|-------------|-------|
| `CipherHelper::AESCBCEncrypt($plaintext, string $key, string $iv = ''): string` | aes cbc 加密。 |
| `CipherHelper::AESCBCDecrypt(string $encrypted, string $key, string $iv = ''): array` | aes cbc 解密。 |

### [DBHelper](./src/DBHelper.php)

| 调用方式                                                                                             | 功能                 |
|--------------------------------------------------------------------------------------------------|--------------------|
| `DBHelper::batchUpdateCaseWhen(string $tableName, array $where, array $needUpdateFields): array` | 生成批量更新的 sql 语句。    |
| `DBHelper::upsert(string $tableName, array $data, array $columns): array`                        | 生成批量更新或写入的 sql 语句。 |


### [FileHelper](./src/FileHelper.php)

| 调用方式 | 功能 |
|-------------|-------|
| `FileHelper::humanFileSize(int $bytes, int $decimals = 2): string` | 返回可读性更好的文件大小。 |


### [IDCardHelper](./src/IDCardHelper.php)

| 调用方式 | 功能 |
|-------------|-------|
| `IDCardHelper::isChinaIDCardDate(string $year, string $month, string $day): bool` | 验证出生日期是否合法。 |
| `IDCardHelper::getValidateCode(string $id): string` | 根据身份证号前17位，算出识别码。|
| `IDCardHelper::isChinaIDCard(string $id, bool $ban15 = true): bool` | 验证身份证号。检查给定的身份证号是否合法。 |
| `IDCardHelper::getChinaIDCardSex(string $id): int` | 根据身份证号，自动返回对应的性别。 |
| `IDCardHelper::getConstellationByChinaIDCard(string $id): string` | 根据身份证号码，返回对应的星座。 |
| `IDCardHelper::getChineseZodiacByChinaIDCard(string $id): string` | 根据身份证号码，返回对应的生肖。 |


### [StrHelper](./src/StrHelper.php)

| 调用方式 | 功能 |
|-------------|-------|
| `StrHelper::genRandomStr(int $len = 16, int $type = 0): string` | 生成随机字符串。 |
| `StrHelper::base64UrlEncode(string $input): string` | Base64编码，使用URL和文件名安全字符集。 |
| `StrHelper::base64UrlDecode(string $input)` | Base64解码，使用URL和文件名安全字符集。 |
| `StrHelper::hide(string $string, int $start = 0, int $length = 0, string $re = '*'): string` | 脱敏函数。将一个字符串部分字符用指定的替代符隐藏，返回处理后的字符串。 |
| `StrHelper::FullOrHalfWidthTrans(string $str, bool $isFullToHalf = false)` | 字符串全角和半角之间的转换。 |


### [TimeHelper](./src/TimeHelper.php)

| Method | Description |
|--------|-------------|
| `TimeHelper::Milliseconds(): int` | 获取当前时间的毫秒数。|
| `TimeHelper::Microseconds(): int` | 获取当前时间的微秒数。|
| `TimeHelper::Nanoseconds(): int` | 获取当前时间的纳秒数。|
| `TimeHelper::humanTime(int $seconds): string` | 返回可读性更好的时间表示。|

