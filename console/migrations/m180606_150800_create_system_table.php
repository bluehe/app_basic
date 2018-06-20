<?php

use yii\db\Migration;

/**
 * Handles the creation of table `system`.
 */
class m180606_150800_create_system_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $table = '{{%system}}';
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT="系统表"';
        }

        $this->createTable($table, [
            'id' => $this->primaryKey()->comment('ID'),
            'parent_id' => $this->integer()->comment('父ID'),
            'code' => $this->string(30)->notNull()->unique()->comment('代码'),
            'tag' => $this->string(20)->notNull()->comment('标签'),
            'type' => $this->string(10)->notNull()->comment('类型'),
            'store_range' => $this->string()->notNull()->comment('范围'),
            'store_dir' => $this->string()->notNull()->comment('目录'),
            'value' => $this->text()->notNull()->comment('值'),
            'sort_order' => $this->smallInteger(3)->notNull()->defaultValue(1)->comment('排序'),
            "FOREIGN KEY ([[parent_id]]) REFERENCES {$table}([[id]]) ON DELETE CASCADE ON UPDATE CASCADE",
                ], $tableOptions);
        $this->createIndex('parent_id', $table, 'parent_id');

        //插入数据
        $this->batchInsert($table, ['id', 'parent_id', 'code', 'tag', 'type', 'store_range', 'store_dir', 'value', 'sort_order'], [
            [1, NULL, 'system', '系统信息', 'group', '', '', '', 1],
            [2, NULL, 'smtp', '邮件设置', 'group', '', '', '', 2],
            [3, NULL, 'captcha', '验证码设置', 'group', '', '', '', 3],
            [4, NULL, 'sms', '短信设置', 'group', '', '', '', 4],
            [5, NULL, 'agreement', '协议设置', 'group', '', '', '', 5],
            [101, 1, 'system_name', '网站名称', 'text', '', '', '', 1],
            [102, 1, 'system_title', '网站标题', 'text', '', '', '', 2],
            [103, 1, 'system_keywords', '关键字', 'textarea', '3', '', '', 3],
            [104, 1, 'system_desc', '网站描述', 'textarea', '3', '', '', 4],
            [105, 1, 'system_icp', '备案信息', 'text', '', '', '', 5],
            [106, 1, 'system_statcode', '第三方统计', 'textarea', '3', '', '', 6],
            [201, 2, 'smtp_service', '自定义邮件', 'radio', '{"0":"否","1":"是"}', '', '0', 1],
            [202, 2, 'smtp_ssl', '加密连接(SSL)', 'radio', '{"0":"否","1":"是"}', '', '0', 2],
            [203, 2, 'smtp_host', 'SMTP服务器', 'text', '', '', '', 3],
            [204, 2, 'smtp_port', 'SMTP端口', 'text', '', '', '', 4],
            [205, 2, 'smtp_from', '发件人地址', 'text', '', '', '', 5],
            [206, 2, 'smtp_username', 'SMTP用户名', 'text', '', '', '', 6],
            [207, 2, 'smtp_password', 'SMTP密码', 'password', '', '', '', 7],
            [208, 2, 'smtp_charset', '邮件编码', 'radio', '{"1":"UTF-8","2":"GB2312"}', '', '1', 8],
            [301, 3, 'captcha_open', '启用验证码', 'checkbox', '{"1":"新用户注册","2":"用户登录","3":"找回密码"}', '', '', 1],
            [302, 3, 'captcha_loginfail', '登录失败显示', 'radio', '{"0":"否","1":"是"}', '', '0', 2],
            [303, 3, 'captcha_length', '验证码长度', 'text', '', '', '6', 3],
            [401, 4, 'sms_service', '启用短信', 'radio', '{"0":"否","1":"是"}', '', '0', 1],
            [402, 4, 'sms_platform', '短信平台', 'radio', '{"aliyun":"阿里云","cloudsmser":"中国云信","submail":"赛邮"}', '', 'aliyun', 2],
            [403, 4, 'sms_key', 'Key', 'text', '', '', '', 3],
            [404, 4, 'sms_secret', 'Secret', 'password', '', '', '', 4],
            [405, 4, 'sms_sign', '短信签名', 'text', '', '', '', 5],
            [406, 4, 'sms_captcha', '验证码模板', 'text', '', '', '', 6],
            [501, 5, 'agreement_open', '启用协议', 'radio', '{"0":"否","1":"是"}', '', '0', 1],
            [502, 5, 'agreement_service', '服务协议', 'text', '', '', '', 2],
            [503, 5, 'agreement_privacy', '隐私声明', 'text', '', '', '', 3],
           
        ]);
        
        $this->update($table, ['value'=>'<p><strong>本站服务协议</strong>
</p>
<p>为获得本站提供的全面服务，服务使用人（以下简称“用户”）应当同意本协议的全部条款，并按照页面上的提示完成全部的注册程序。用户在进行注册程序的过程中选择“同意”按钮，即表示用户完全接受本协议下的全部条款，并与本站达成协议。
</p>
<p>您在使用本站提供的各项服务之前，应仔细阅读本协议。如您不同意此协议及其不时发布的修改，您可以主动取消本站提供的服务；您一旦使用本站的服务，即视为您已了解并完全同意用户协议的各项内容（包括本站对用户协议随时所做的任何修改），并成为本站的用户。
</p>
<p><strong>一、协议构成</strong>
</p>
<p>1．本协议为本站所有服务的通用条款。
</p>
<p>2．本站有可能针对某项服务添加相关特别约定或制定专项服务协议，届时用户接受该项服务的前提为同意该项服务所附带的所有法律文件，包括但不限于本网络服务使用协议及专项服务协议。同时用户知悉并同意如本网络服务使用协议与任何针对某项服务添加相关特别约定、专项服务协议不一致的，均优先适用针对某项服务添加相关特别约定及专项服务协议的约定。
</p>
<p>3．专项服务协议包括但不限于：
</p>
<p>（1）《本站隐私政策》
</p>
<p><strong>二、用户注册成为本站的注册用户</strong>
</p>
<p>4．除法律法规另有规定或者本协议另有约定，本站旗下的所有服务均采取自愿注册的原则。
</p>
<p>5．法律法规等要求必须实名注册的，按照法律法规的要求办理实名注册。
</p>
<p>6．用户在注册成为本站注册用户时，必须按照法律法规的要求提供相应资料。必须实名注册的，应当提供真实的身份信息。针对实名注册的用户，本站按照“后台实名、前台自愿”的原则，对实名注册用户进行基于移动电话号码等真实身份信息认证。
</p>
<p>7．对于实名注册的账号，本站有权对用户注册信息审核检查，发现通过虚假身份信息注册的账号的，本站有权封停、注销该账号。
</p>
<p>8．对于实名注册的账号，用户在申请注册时，必须向本站提供真实、完整、准确的个人资料，如个人资料有任何变动，必须及时更新。因用户提供个人资料不准确、不真实而引发的一切后果由用户承担。本站不会由于您的资料信息不真实、不准确，或您的资料信息未能及时更新，或因您遗忘、丢失了密码而引起的任何损失或损害承担任何责任。
</p>
<p>9．用户不应将其账号、密码转让、出借或以任何脱离用户控制的形式交由他人使用。如用户发现其账号遭他人非法使用，应立即通知本站。用户应当为自身注册账号下的一切行为负责，因用户行为而导致的用户自身或其他任何第三方的任何损失或损害，本站不承担责任。因黑客行为或用户的保管疏忽导致账号、密码遭他人非法使用，本站不承担任何责任。
</p>
<p>10．注册用户存在假冒他人名义开设账号、多次编造传播恶性谣言等情节恶劣的，本站有权将该用户纳入黑名单，限制或者禁止该注册用户使用本站的部分或者全部服务。
</p>
<p><strong>三、用户使用本站提供的服务</strong>
</p>
<p>11．用户在使用本站提供的服务时，必须遵守中华人民共和国相关法律法规的规定，用户应同意将不会利用本服务进行任何违法或不正当的活动，不得包含但不限于以下内容：
</p>
<p>（1）上载、展示、张贴、传播或以其它方式传送含有下列内容之一的信息：
</p>
<p>·反对宪法所确定的基本原则的；
</p>
<p>·危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；
</p>
<p>·损害国家荣誉和利益的；
</p>
<p>·煽动民族仇恨、民族歧视，破坏民族团结的；
</p>
<p>·破坏国家宗教政策，宣扬邪教和封建迷信的；
</p>
<p>·散布谣言，扰乱社会秩序，破坏社会稳定的；
</p>
<p>·散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；
</p>
<p>·侮辱或者诽谤他人，侵害他人合法权益的；
</p>
<p>·侵犯他人知识产权的，包括但不限于专利权、商标权、著作权；
</p>
<p>·侵犯他人商业秘密的；
</p>
<p>·含有法律、行政法规禁止的其他内容的；
</p>
<p>·单纯的、无实质性内容的广告页面的；
</p>
<p>·含有虚假、有害、胁迫、侵害他人隐私、骚扰、侵害、中伤、粗俗、猥亵或其它道德上令人反感内容的；
</p>
<p>·含有中国法律、法规、规章、条例以及任何具有法律效力的规范所限制或禁止的其它内容的；
</p>
<p>（2）用户不得利用本站进行故意制作、传播计算机病毒等破坏性程序，不得针对本服务、与本服务连接的服务器或网络制造干扰、混乱，或违反连接本服务的网络的任何要求、程序、政策或规则，否则本站将保留追究其法律责任的权利并有权将其提交给相关部门处理。如用户在使用本站时违反任何上述规定，本站有权要求用户改正或直接采取一切必要的措施（包括但不限于更改或删除用户张贴的内容等、暂停或终止用户使用网络服务的权利）以减轻和消除用户不当行为造成的影响。
</p>
<p>12．除非与本站另签协议，用户同意本服务仅供个人非商业性质的使用。用户承诺未经本站事先书面同意，不得利用本服务进行广告、销售、商业展示等商业性用途。如果本站发现用户利用本服务进行以上行为，有权删除用户上传内容，或对用户账号进行暂时性或永久性封禁，且不需要对用户另行通知。
</p>
<p>13．用户必须保证，您拥有您上传的照片、文字及背景音乐等作品之著作权或已获得合法授权，您在本网站的上传行为未侵犯任何第三方的合法权益。否则，将由您承担由此带来的一切法律责任；用户不得将任何内部资料、机密资料、涉及他人隐私资料或侵犯任何人的专利、商标、著作权、商业秘密或其他专属权利之内容加以上载、张贴或以其他方式传送。
</p>
<p>14．本站有权对用户上传的图片、添加的文字等内容进行审核，有任何违反法律法规或本协议有关规定的图片、文字，本站有权立即将其删除或屏蔽，且不需要对用户另行通知。
</p>
<p>15．用户须对自己在使用本站过程中的所有行为承担法律责任。用户承担法律责任的形式包括但不限于对受到侵害者进行赔偿，以及在本站首先承担了因用户行为导致的行政处罚或侵权损害赔偿责任后，用户应给予本站等额的赔偿。因用户使用本站而导致任何第三方提出索赔要求或衍生的任何损害或损失，用户应承担全部责任。
</p>
<p><strong>四、服务内容</strong>
</p>
<p>16．本站服务涉及到互联网及移动通讯等服务，可能会受到各个环节不稳定因素的影响。因此服务存在因上述不可抗力、计算机病毒或黑客攻击、系统不稳定、用户所在位置、用户关机、GSM网络、互联网络、通信线路原因等造成的服务中断或不能满足用户要求的风险，使用本服务的用户须承担以上风险。本站对服务的及时性、安全性、准确性不作担保，对因此导致用户不能发送和接受阅读消息、或传递错误，未予储存或其他问题不承担任何责任。对于不可抗力或非本站过错原因导致的用户数据损失、丢失或服务停止，本站将不承担任何责任。
</p>
<p>17．本站会提供与其他国际互联网网站或资源进行的链接。对于前述网站或资源是否可以利用以及利用的后果，本站不予担保。因使用或依赖上述网站和资源所产生的损失或损害，本站也不负担任何责任。
</p>
<p>18．除非本用户协议另有其它明示规定，本站所提供的所有服务，以及未来即将推出的新产品、新功能、新服务，均受到本服务协议之规范。本站有权于任何时间暂时或永久修改甚至终止本服务（或其任何部分），而无论其通知与否，本站对用户和任何第三人均无需承担任何责任。
</p>
<p>19．终止服务
</p>
<p>（1）用户承认并同意本站基于其自行的考虑，因任何理由，包含但不限于用户账号长时间未被使用；本站认为用户已经违反本用户协议的约定，有合理理由怀疑用户提供的个人资料为错误、不真实、过时或不完整，随时终止用户密码、账号或本服务的使用（或服务的任何部分），并将用户在本服务中涉及的任何内容加以移除并删除。
</p>
<p>（2）用户承认并同意：本站有权无需进行事先通知在任何时间暂时或永久变更、中断或终止部分或全部的本站服务，删除用户账号及账号中所有相关信息及文件，或禁止用户继续使用前述文件及本服务，且本站对用户或任何第三人均不承担任何责任。
</p>
<p><strong>五、知识产权和其他合法权益</strong>
</p>
<p>20．本站提供的网络服务内容可能包括：文字、软件、声音、图片、录像、图表等。所有这些内容均为本站或授权本站使用的合法权利人所有，除非事先经本站或其权利人的合法授权，任何人皆不得擅自以任何形式使用，否则本站可立即终止向用户提供产品和服务，并依法追究其法律责任，赔偿本站一切损失。
</p>
<p>21．用户只有在获得本站或其他相关权利人的授权之后才能使用这些内容，而不能擅自复制、再造这些内容，或创造与内容有关的派生产品。
</p>
<p>22．用户原创作品上载、传送、输入或以其他方式提供至本站网站时，视为用户授予本站对其作品的使用权，该授权无地域、期限、方式限制，该授权为免费授权，本站可在现行法律范围内就该作品进行使用，包括但不限于复制、发行、出租、展览、表演、放映、广播、信息网络传播、摄制、改编、翻译、汇编等，并可将前述权利转、分授权给其他第三方。
</p>
<p><strong>六、服务变更、中断或终止</strong>
</p>
<p>23．鉴于网络服务的特殊性，用户同意本站有权根据业务发展情况随时变更、中断或终止部分或全部的网络服务而无需通知用户，也无需对任何用户或任何第三方承担任何责任。
</p>
<p>24．为了网站的正常运行，本站需要定期或不定期地对提供网络服务的平台（如互联网网站、移动网络等）或相关的设备进行检修或者维护，如因此类情况而造成网络服务在合理时间内的中断，本站无需为此承担任何责任，但本站应尽可能事先进行通告。
</p>
<p>25．如发生下列任何一种情形，本站有权随时中断或终止向用户提供本《协议》项下的网络服务（包括收费网络服务）而无需对用户或任何第三方承担任何责任：
</p>
<p>（1）用户提供的个人资料不真实；
</p>
<p>（2）用户违反本协议中规定的使用规则。
</p>
<p><strong>七、隐私保护</strong>
</p>
<p>26．保护用户隐私是本站的一项基本政策，本站保证不对外公开或向第三方提供单个用户的注册资料及用户在使用网络服务时存储在本站的非公开内容，但下列情况除外：
</p>
<p>（1）事先获得用户的明确授权；
</p>
<p>（2）根据有关的法律法规要求；
</p>
<p>（3）按照相关政府主管部门的要求；
</p>
<p>（4）为维护社会公众的利益；
</p>
<p>（5）为维护本站的合法权益。
</p>
<p>27．本站可能会与第三方合作向用户提供相关的网络服务，在此情况下，如该第三方同意承担与本站同等的保护用户隐私的责任，则本站有权将用户的注册资料等提供给该第三方。
</p>
<p>28．在不透露单个用户隐私资料的前提下，本站有权对整个用户数据库进行分析并对用户数据库进行商业上的利用。
</p>
<p>29．本站就隐私保护制定了专门的文件《隐私政策》。该《隐私政策》构成本协议的组成部分。
</p>
<p><strong>八、免责声明</strong>
</p>
<p>30．本站不担保网络服务一定能满足用户的要求，也不担保网络服务不会中断，对网络服务的及时性、安全性、准确性也都不作担保。
</p>
<p>31．本站不保证为用户提供便利而设置的外部链接的准确性和完整性，同时，对于该等外部链接指向的不由本站实际控制的任何网页上的内容，本站不承担任何责任。
</p>
<p>32．对于因电信系统或互联网网络故障、计算机故障或病毒、信息损坏或丢失、计算机系统问题或其它任何不可抗力原因而产生损失，本站不承担任何责任，但将尽力减少因此而给用户造成的损失和影响。
</p>
<p><strong>九、法律及争议解决</strong>
</p>
<p>33．本协议的订立、执行、解释及争议的解决均应适用中华人民共和国法律。
</p>
<p>34．因本协议引起的或与本协议有关的任何争议，各方应友好协商解决；协商不成的，任何一方均可将有关争议提交至本站所属地人民法院处理。
</p>
<p><strong>十、其他条款</strong>
</p>
<p>35．如果本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，或违反任何适用的法律，则该条款被视为删除，但本协议的其余条款仍应有效并且有约束力。
</p>
<p>36．本站未行使或执行本服务协议任何权利或规定，不构成对前述权利或权利的放弃。
</p>
<p>37．本站有权随时根据有关法律、法规的变化以及公司经营状况和经营策略的调整等修改本协议。如该等修订造成用户在本协议下权利的实质减少，本站将在修订生效前通过在主页上显著位置提示或向用户发送电子邮件或以其他方式通知用户。如果用户不同意本站对本协议相关条款所做的修改，用户有权停止使用网络服务。如果用户继续使用网络服务，则视为用户接受本站对本协议相关条款所做的修改。
</p>
<p>38．本站向用户发出的通知，将采用页面公告的形式进行，该通知于发送之日视为已送达收件人。用户对于本站的通知应当通过本站对外正式公布的通信地址、传真号码、电子邮件地址等联系信息进行送达。
</p>
<p>39．本站在法律允许最大范围拥有对本协议的解释权与修改权。用户对服务的任何部分或本服务条款任何部分的意见及建议可通过客户服务部门与本站联系。
</p>'],['code'=>'agreement_service']);
        
        $this->update($table, ['value'=>'<p><strong>本站隐私政策</strong>
</p>
<p>本站郑重声明，本站尊重并严格保护所有使用本站提供的在线网络服务的个人隐私。请您认真阅读以下条款，以了解我们的政策。本政策的条款可能会不定时更改，请注意定期查阅。
</p>
<p>本站注重对您的个人隐私的保护。有时候我们需要某些信息才能为您提供您请求的服务，本隐私政策解释了这些情况下的数据收集和使用情况。本隐私政策适用于本站的所有相关服务。
</p>
<p><strong>一、定义</strong>
</p>
<p>1．个人信息，是指以电子或者其他方式记录的能够单独或者与其他信息结合识别用户个人身份的各种信息，包括但不限于用户的姓名、出生日期、身份证件号码、住址、电话号码等。
</p>
<p>2．本站名下所有的网站下称“我们”或者“本站”。
</p>
<p>3．关联公司，是指与本站存在业务合作的公司的单称或合称。
</p>
<p><strong>二、我们可能收集哪些个人信息</strong>
</p>
<p>我们提供服务时，可能会收集、储存和使用下列与您有关的信息。如果您不提供相关信息，可能无法注册成为我们的用户或无法享受我们提供的某些服务，或者无法达到相关服务拟达到的效果。
</p>
<p>（一）您提供的信息
</p>
<p>1．您在注册账户或使用我们的服务时，<strong>向我们提供的相关个人信息，例如电话号码、电子邮件等</strong>；
</p>
<p>2．您通过我们的服务向其他方提供的共享信息，以及您使用我们的服务时所储存的信息。
</p>
<p>（二）我们获取的您的信息
</p>
<p>您使用服务时我们可能收集如下信息：
</p>
<p>1．日志信息，指您使用我们的服务时，系统可能通过cookies或其他方式自动采集的技术信息，包括：
</p>
<p>（1）设备或软件信息，例如您的移动设备、网页浏览器或用于接入我们服务的其他程序所提供的配置信息、您的IP地址和移动设备所用的版本和设备识别码；
</p>
<p>（2）在使用我们服务时搜索或浏览的信息，例如您使用的网页搜索词语、访问的社交媒体页面url地址，以及您在使用我们服务时浏览或要求提供的其他信息和内容详情；
</p>
<p>（3）有关您曾使用的移动应用程序（APP）和其他软件的信息，以及您曾经使用该等移动应用和软件的信息；
</p>
<p>（4）您通过我们的服务进行通讯的信息，例如曾通讯的账号，以及通讯时间、数据和时长；
</p>
<p>（5）您通过我们的服务分享的内容所包含的信息，例如拍摄或上传的共享照片或录像的日期、时间或地点等。
</p>
<p>2．位置信息，指您开启设备定位功能并使用我们基于位置提供的相关服务时，收集的有关您位置的信息，包括：
</p>
<p>（1）您通过具有定位功能的移动设备使用我们的服务时，通过GPS或WiFi等方式收集的您的地理位置信息；
</p>
<p>（2）您或其他用户提供的包含您所处地理位置的实时信息，例如您提供的账户信息中包含的您所在地区信息，您或其他人上传的显示您当前或曾经所处地理位置的共享信息，您或其他人共享的照片包含的地理标记信息。
</p>
<p>您可以通过关闭定位功能，停止对您的地理位置信息的收集。
</p>
<p><strong>三、我们可能会如何使用您的个人信息</strong>
</p>
<p>我们可能将在向您提供服务的过程之中所收集的信息用作下列用途：
</p>
<p>1．向您提供服务；
</p>
<p>2．在我们提供服务时，用于身份验证、客户服务、安全防范、诈骗监测、存档和备份用途，确保我们向您提供的产品和服务的安全性；
</p>
<p>3．帮助我们设计新服务，改善我们现有服务；
</p>
<p>4．使我们更加了解您如何接入和使用我们的服务，从而针对性地回应您的个性化需求，例如语言设定、位置设定、个性化的帮助服务和指示，或对您和其他用户作出其他方面的回应；
</p>
<p>5．向您提供与您更加相关的广告以替代普遍投放的广告；
</p>
<p>6．评估我们服务中的广告和其他促销及推广活动的效果，并加以改善；
</p>
<p>7．软件认证或管理软件升级；
</p>
<p>8．让您参与有关我们产品和服务的调查。
</p>
<p>为了让您有更好的体验、改善我们的服务或您同意的其他用途，在符合相关法律法规的前提下，我们可能将通过某一项服务所收集的信息，以汇集信息或者个性化的方式，用于我们的其他服务。例如，在您使用我们的一项服务时所收集的信息，可能在另一服务中用于向您提供特定内容，或向您展示与您相关的、非普遍推送的信息。如果我们在相关服务中提供了相应选项，您也可以授权我们将该服务所提供和储存的信息用于我们的其他服务。
</p>
<p><strong>四、我们如何存储信息</strong>
</p>
<p>我们收集的有关您的信息和资料将保存在本站及（或）其关联公司的服务器上，这些信息和资料可能传送至您所在国家、地区或我们收集信息和资料所在地并在该地被访问、存储和展示。
</p>
<p>我们将在实现本隐私政策中所述目的所必需的期间内保留你的个人信息，除非法律要求或允许在更长的期间内保留这些信息。
</p>
<p><strong>五、我们为您的个人信息保密</strong>
</p>
<p>保护用户隐私是我们的一项基本政策，本站保证不对外公开或向第三方提供您的申请资料及您在使用网络服务时存储在本站的个人信息，但下列情况除外：
</p>
<p>(1)事先获得用户的明确授权；
</p>
<p>(2)根据有关的法律法规要求；
</p>
<p>(3)按照相关政府主管部门的要求；
</p>
<p>(4)为维护社会公众的利益；
</p>
<p>(5)为维护本站的合法权益；
</p>
<p>(6)您同意让第三方共享资料；
</p>
<p>(7)我们发现您违反了本站服务条款或任何其他产品服务的使用规定；
</p>
<p>(8)只有透露你的个人资料，才能提供你所要求的产品和服务；
</p>
<p>(9)我们需要向代表我们提供产品或服务的公司提供资料（除非我们另行通知你，否则这些公司无权使用你的身份识别资料）；
</p>
<p>我们可能会与第三方合作向您提供相关的网络服务，在此情况下，如该第三方同意承担与本站同等的保护用户隐私的责任，则本站可将您的个人信息等提供给该第三方。
</p>
<p>在不透露您隐私资料的前提下，本站有权对整个用户数据库进行分析并对用户数据库进行商业上的利用（包括但不限于公布、分析或以其它方式使用用户访问量、访问时段、用户偏好等用户数据信息）。
</p>
<p><strong>六、如何查阅、修改您的个人信息</strong>
</p>
<p>我们将尽一切可能采取适当的技术手段，保证您可以访问、更新和更正自己的注册信息或使用我们的服务时提供的其他个人信息。
</p>
<p>查询、更正信息渠道：进入本站登录页面，使用您的本站账号进行登录。进入登录页面后，您可以点击“账号信息”，即可查看查阅、修改您的个人信息（包括您的基本资料、注册手机、绑定邮箱、头像、密码等等）。如在查询、更正信息时有任何问题，您可以按照本政策第十三条“建议、投诉渠道”的指引向我们反馈。
</p>
<p>在访问、更新、更正和删除前述信息时，我们可能会要求您进行身份验证，以保障账户安全。
</p>
<p><strong>七、信息安全</strong>
</p>
<p>我们仅在本隐私政策所述目的所必需的期间和法律法规要求的时限内保留您的个人信息。
</p>
<p>我们使用各种安全技术和程序，以防信息的丢失、不当使用、未经授权阅览或披露。例如，在某些服务中，我们将利用加密技术来保护您提供的个人信息。但请您理解，由于技术的限制以及可能存在的各种恶意手段，在互联网行业，即便竭尽所能加强安全措施，也不可能始终保证信息百分之百的安全。您需要了解，您接入我们的服务所用的系统和通讯网络，有可能因我们可控范围外的因素而出现问题。
</p>
<p><strong>八、未成年人使用为我们的服务</strong>
</p>
<p>本站承诺，仅在征得其监护人的明示同意的前提下，我们才会处理未成年人的个人信息；
</p>
<p>我们鼓励父母或监护人指导未满十八岁的未成年人使用我们的服务。我们建议未成年人鼓励他们的父母或监护人阅读本隐私政策，并建议未成年人在提交的个人信息之前寻求父母或监护人的同意和指导。
</p>
<p><strong>九、对其他网站的链接</strong>
</p>
<p>本站含有其他网站的链接，我们不对这些网站的内容及他们关于隐私权的行为负责，建议您仔细阅读这些网站的个人信息隐私政策并确定是否接受该隐私政策。
</p>
<p><strong>十、向第三方提供您的个人信息</strong>
</p>
<p>因提供网络服务的需要，<strong>经过您的同意后</strong>，我们可能会向合作伙伴、关联公司、第三方服务商或者代理公司等提供您的个人信息。
</p>
<p><strong>十一、免责声明</strong>
</p>
<p>就下列相关事宜的发生，本站不承担任何法律责任：
</p>
<p>（1）本站根据法律规定或相关政府的要求提供您的个人信息；
</p>
<p>（2）由于您将用户密码告知他人或与他人共享注册账号，由此导致的任何个人信息的泄漏，或其他非因本站原因导致的个人信息的泄漏；
</p>
<p>（3）任何第三方根据本站各服务条款及政策中所列明的情况使用您的个人信息，由此所产生的纠纷；
</p>
<p>（4）任何由于黑客攻击、电脑病毒侵入或政府管制而造成的暂时性网站关闭；
</p>
<p>（5）因不可抗力导致的任何后果；
</p>
<p>（6）本站在各服务条款及政策中列明的使用方式或免责情形。
</p>
<p>十二、对隐私政策的认同和修订
</p>
<p>您在使用本站网络服务和我们的网站时，即表示您同意我们收集并使用您的资料（如本政策所述），并表示您认同我们的网络服务使用协议。
</p>
<p>本站保留修改此隐私政策的权力。我们可能适时修订本隐私政策的条款，该等修订构成本隐私政策的一部分。如该等修订造成您在本隐私政策下权利的实质减少，我们将在修订生效前通过在主页上显著位置提示或向您发送电子邮件或以其他方式通知您。在该种情况下，若您继续使用我们的服务，即表示同意接受经修订的本隐私政策的约束。
</p>
<p><strong>如果您不同意本站修改的内容，您可以主动取消获得的网络服务。</strong>如果您在修改内容公告后15天内未主动取消服务，则视为接受本政策的变更；修改内容公告后您如果仍继续使用本站提供的产品和服务亦构成对本政策变更的接受。
</p>
<p>十三、建议、投诉渠道
</p>
<p>您可以通过拨打我们的客服电话，或者通过发送电子邮件的方式，与我们取得联系，我们会给予您必要的帮助。
</p>
<p>十四、法律适用及争议解决
</p>
<p>1．本隐私政策的订立、执行、解释及争议的解决均应适用中华人民共和国法律。
</p>
<p>2．因本隐私政策引起的或与本隐私政策有关的任何争议，各方应友好协商解决；协商不成的，<strong>任何一方均可将有关争议提交至本站所属地人民法院处理。</strong>
</p>
<p>十五、文件组成
</p>
<p>本隐私政策构成《本站服务协议》的组成部分。《本站服务协议》与本隐私政策不一致的，以本隐私政策为准。本隐私政策未约定的，按照《本站服务协议》的约定执行。
</p>
<p>十六、生效时间
</p>
<p>本隐私政策自2018年6月1日生效。
</p>'],['code'=>'agreement_privacy']);
    }
   
    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('{{%system}}');
    }

}
