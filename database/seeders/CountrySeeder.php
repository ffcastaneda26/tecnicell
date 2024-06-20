<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->warn(__('Creating') . ' ' . __('Countries Table'));

        $sql="INSERT INTO `countries` VALUES (1, 'ARUBA', 'ABW', 'AW', 0),
        (2, 'AFGHANISTAN', 'AFG', 'AF', 0),
        (3, 'ANGOLA', 'AGO', 'AO', 0),
        (4, 'ANGUILLA', 'AIA', 'AI', 0),
        (5, 'ALBANIA', 'ALB', 'AL', 0),
        (6, 'ANDORRA', 'AND', 'AD', 0),
        (7, 'NETHERLANDS ANTILLES', 'ANT', 'AN', 0),
        (8, 'UNITED ARAB EMIRATES', 'ARE', 'AE', 0),
        (9, 'ARGENTINA', 'ARG', 'AR', 0),
        (10, 'ARMENIA', 'ARM', 'AM', 0),
        (11, 'AMERICAN SAMOA', 'ASM', 'AS', 0),
        (12, 'ANTARCTICA', 'ATA', 'AQ', 0),
        (13, 'FRENCH SOUTHERN TERRITORIES', 'ATF', 'TF', 0),
        (14, 'ANTIGUA AND BARBUDA', 'ATG', 'AG', 0),
        (15, 'AUSTRALIA', 'AUS', '', 0),
        (16, 'AUSTRIA', 'AUT', 'AT', 0),
        (17, 'AZERBAIJAN', 'AZE', 'AZ', 0),
        (18, 'BURUNDI', 'BDI', 'BI', 0),
        (19, 'BELGIUM', 'BEL', '', 0),
        (20, 'BENIN', 'BEN', 'BJ', 0),
        (21, 'BURKINA FASO', 'BFA', 'BF', 0),
        (22, 'BANGLADESH', 'BGD', 'BD', 0),
        (23, 'BULGARIA', 'BGR', 'BG', 0),
        (24, 'BAHRAIN', 'BHR', 'BH', 0),
        (25, 'BAHAMAS', 'BHS', 'BS', 0),
        (26, 'BOSNIA AND HERZEGOVINA', 'BIH', 'BA', 0),
        (27, 'BELARUS', 'BLR', 'BY', 0),
        (28, 'BELIZE', 'BLZ', 'BZ', 0),
        (29, 'BERMUDA', 'BMU', 'BM', 0),
        (30, 'BOLIVIA', 'BOL', 'BO', 0),
        (31, 'BRAZIL', 'BRA', 'BR', 0),
        (32, 'BARBADOS', 'BRB', 'BB', 0),
        (33, 'BRUNEI', 'BRN', 'BN', 0),
        (34, 'BHUTAN', 'BTN', 'BT', 0),
        (35, 'BOUVET ISLAND', 'BVT', 'BV', 0),
        (36, 'BOTSWANA', 'BWA', 'BW', 0),
        (37, 'CENTRAL AFRICAN REPUBLIC', 'CAF', 'CF', 0),
        (38, 'CANADA', 'CAN', '', 0),
        (39, 'COCOS (KEELING) ISLANDS', 'CCK', 'CC', 0),
        (40, 'SWITZERLAND', 'CHE', 'CH', 0),
        (41, 'CHILE', 'CHL', 'CL', 0),
        (42, 'CHINA', 'CHN', 'CN', 0),
        (44, 'CAMEROON', 'CMR', 'CM', 0),
        (45, 'CONGO', 'COD', '', 0),
        (46, 'COOK ISLANDS', 'COK', 'CK', 0),
        (47, 'COLOMBIA', 'COL', 'CO', 0),
        (48, 'COMOROS', 'COM', 'KM', 0),
        (49, 'CAPE VERDE', 'CPV', 'CV', 0),
        (50, 'COSTA RICA', 'CRI', 'CR', 0),
        (51, 'CUBA', 'CUB', 'CU', 0),
        (52, 'CHRISTMAS ISLAND', 'CXR', 'CX', 0),
        (53, 'CAYMAN ISLANDS', 'CYM', 'KY', 0),
        (54, 'CYPRUS', 'CYP', 'CY', 0),
        (55, 'CZECH REPUBLIC', 'CZE', 'CZ', 0),
        (56, 'GERMANY', 'DEU', 'DE', 0),
        (57, 'DJIBOUTI', 'DJI', 'DJ', 0),
        (58, 'DOMINICA', 'DMA', 'DM', 0),
        (59, 'DENMARK', 'DNK', 'DK', 0),
        (60, 'DOMINICAN REPUBLIC', 'DOM', 'DO', 0),
        (61, 'ALGERIA', 'DZA', 'DZ', 0),
        (62, 'ECUADOR', 'ECU', 'EC', 0),
        (63, 'EGYPT', 'EGY', 'EG', 0),
        (64, 'ERITREA', 'ERI', 'ER', 0),
        (65, 'WESTERN SAHARA', 'ESH', 'EH', 0),
        (66, 'SPAIN', 'ESP', 'ES', 0),
        (67, 'ESTONIA', 'EST', 'EE', 0),
        (68, 'ETHIOPIA', 'ETH', 'ET', 0),
        (69, 'FINLAND', 'FIN', 'FI', 0),
        (70, 'FIJI ISLANDS', 'FJI', 'FJ', 0),
        (71, 'FALKLAND ISLANDS', 'FLK', 'FK', 0),
        (72, 'FRANCE', 'FRA', 'FR', 0),
        (73, 'FAROE ISLANDS', 'FRO', 'FO', 0),
        (74, 'MICRONESIA', 'FSM', '', 0),
        (75, 'GABON', 'GAB', 'GA', 0),
        (76, 'UNITED KINGDOM', 'GBR', 'GB', 0),
        (77, 'GEORGIA', 'GEO', 'GE', 0),
        (78, 'GHANA', 'GHA', 'GH', 0),
        (79, 'GIBRALTAR', 'GIB', 'GI', 0),
        (80, 'GUINEA', 'GIN', 'GN', 0),
        (81, 'GUADELOUPE', 'GLP', 'GP', 0),
        (82, 'GAMBIA', 'GMB', 'GM', 0),
        (83, 'GUINEA-BISSAU', 'GNB', 'GW', 0),
        (84, 'EQUATORIAL GUINEA', 'GNQ', 'GQ', 0),
        (85, 'GREECE', 'GRC', 'GR', 0),
        (86, 'GRENADA', 'GRD', 'GD', 0),
        (87, 'GREENLAND', 'GRL', 'GL', 0),
        (88, 'GUATEMALA', 'GTM', 'GT', 0),
        (89, 'FRENCH GUIANA', 'GUF', 'GF', 0),
        (90, 'GUAM', 'GUM', 'GU', 0),
        (91, 'GUYANA', 'GUY', 'GY', 0),
        (92, 'HONG KONG', 'HKG', 'HK', 0),
        (93, 'HEARD ISLAND AND MCDONALD ISLANDS', 'HMD', 'HM', 0),
        (94, 'HONDURAS', 'HND', 'HN', 0),
        (95, 'CROATIA', 'HRV', 'HR', 0),
        (96, 'HAITI', 'HTI', 'HT', 0),
        (97, 'HUNGARY', 'HUN', 'HU', 0),
        (98, 'INDONESIA', 'IDN', 'ID', 0),
        (99, 'INDIA', 'IND', 'IN', 0),
        (100, 'BRITISH INDIAN OCEAN TERRITORY', 'IOT', 'IO', 0),
        (101, 'IRELAND', 'IRL', 'IE', 0),
        (102, 'IRAN', 'IRN', 'IR', 0),
        (103, 'IRAQ', 'IRQ', 'IQ', 0),
        (104, 'ICELAND', 'ISL', 'IS', 0),
        (105, 'ISRAEL', 'ISR', 'IL', 0),
        (106, 'ITALY', 'ITA', 'IT', 0),
        (107, 'JAMAICA', 'JAM', 'JM', 0),
        (108, 'JORDAN', 'JOR', 'JO', 0),
        (109, 'JAPAN', 'JPN', 'JP', 0),
        (110, 'KAZAKSTAN', 'KAZ', 'KZ', 0),
        (111, 'KENYA', 'KEN', 'KE', 0),
        (112, 'KYRGYZSTAN', 'KGZ', 'KG', 0),
        (113, 'CAMBODIA', 'KHM', 'KH', 0),
        (114, 'KIRIBATI', 'KIR', 'KI', 0),
        (115, 'SAINT KITTS AND NEVIS', 'KNA', 'KN', 0),
        (116, 'SOUTH KOREA', 'KOR', 'KR', 0),
        (117, 'KUWAIT', 'KWT', 'KW', 0),
        (118, 'LAOS', 'LAO', 'LA', 0),
        (119, 'LEBANON', 'LBN', 'LB', 0),
        (120, 'LIBERIA', 'LBR', 'LR', 0),
        (121, 'LIBYAN ARAB JAMAHIRIYA', 'LBY', 'LY', 0),
        (122, 'SAINT LUCIA', 'LCA', 'LC', 0),
        (123, 'LIECHTENSTEIN', 'LIE', 'LI', 0),
        (124, 'SRI LANKA', 'LKA', 'LK', 0),
        (125, 'LESOTHO', 'LSO', 'LS', 0),
        (126, 'LITHUANIA', 'LTU', 'LT', 0),
        (127, 'LUXEMBOURG', 'LUX', 'LU', 0),
        (128, 'LATVIA', 'LVA', 'LV', 0),
        (129, 'MACAO', 'MAC', 'MO', 0),
        (130, 'MOROCCO', 'MAR', 'MA', 0),
        (131, 'MONACO', 'MCO', 'MC', 0),
        (132, 'MOLDOVA', 'MDA', 'MD', 0),
        (133, 'MADAGASCAR', 'MDG', 'MG', 0),
        (134, 'MALDIVES', 'MDV', 'MV', 0),
        (135, 'MEXICO', 'MEX', 'MX', 1),
        (136, 'MARSHALL ISLANDS', 'MHL', 'MH', 0),
        (137, 'MACEDONIA', 'MKD', 'MK', 0),
        (138, 'MALI', 'MLI', 'ML', 0),
        (139, 'MALTA', 'MLT', 'MT', 0),
        (140, 'MYANMAR', 'MMR', 'MM', 0),
        (141, 'MONGOLIA', 'MNG', 'MN', 0),
        (142, 'NORTHERN MARIANA ISLANDS', 'MNP', 'MP', 0),
        (143, 'MOZAMBIQUE', 'MOZ', 'MZ', 0),
        (144, 'MAURITANIA', 'MRT', 'MR', 0),
        (145, 'MONTSERRAT', 'MSR', 'MS', 0),
        (146, 'MARTINIQUE', 'MTQ', 'MQ', 0),
        (147, 'MAURITIUS', 'MUS', 'MU', 0),
        (148, 'MALAWI', 'MWI', 'MW', 0),
        (149, 'MALAYSIA', 'MYS', '', 0),
        (150, 'MAYOTTE', 'MYT', 'YT', 0),
        (151, 'NAMIBIA', 'NAM', 'NA', 0),
        (152, 'NEW CALEDONIA', 'NCL', 'NC', 0),
        (153, 'NIGER', 'NER', 'NE', 0),
        (154, 'NORFOLK ISLAND', 'NFK', 'NF', 0),
        (155, 'NIGERIA', 'NGA', 'NG', 0),
        (156, 'NICARAGUA', 'NIC', 'NI', 0),
        (157, 'NIUE', 'NIU', 'NU', 0),
        (158, 'NETHERLANDS', 'NLD', 'NL', 0),
        (159, 'NORWAY', 'NOR', 'NO', 0),
        (160, 'NEPAL', 'NPL', 'NP', 0),
        (161, 'NAURU', 'NRU', 'NR', 0),
        (162, 'NEW ZEALAND', 'NZL', 'NZ', 0),
        (163, 'OMAN', 'OMN', 'OM', 0),
        (164, 'PAKISTAN', 'PAK', 'PK', 0),
        (165, 'PANAMA', 'PAN', 'PA', 0),
        (166, 'PITCAIRN', 'PCN', 'PN', 0),
        (167, 'PERU', 'PER', 'PE', 0),
        (168, 'PHILIPPINES', 'PHL', 'PH', 0),
        (169, 'PALAU', 'PLW', 'PW', 0),
        (170, 'PAPUA NEW GUINEA', 'PNG', 'PG', 0),
        (171, 'POLAND', 'POL', 'PL', 0),
        (172, 'PUERTO RICO', 'PRI', 'PR', 0),
        (173, 'NORTH KOREA', 'PRK', 'KP', 0),
        (174, 'PORTUGAL', 'PRT', 'PT', 0),
        (175, 'PARAGUAY', 'PRY', 'PY', 0),
        (176, 'PALESTINE', 'PSE', 'PS', 0),
        (177, 'FRENCH POLYNESIA', 'PYF', 'PF', 0),
        (178, 'QATAR', 'QAT', 'QA', 0),
        (179, 'RÏ¿½UNION', 'REU', 'RE', 0),
        (180, 'ROMANIA', 'ROM', 'RO', 0),
        (181, 'RUSSIAN FEDERATION', 'RUS', 'RU', 0),
        (182, 'RWANDA', 'RWA', 'RW', 0),
        (183, 'SAUDI ARABIA', 'SAU', 'SA', 0),
        (184, 'SUDAN', 'SDN', 'SD', 0),
        (185, 'SENEGAL', 'SEN', 'SN', 0),
        (186, 'SINGAPORE', 'SGP', 'SG', 0),
        (187, 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'SGS', 'GS', 0),
        (188, 'SAINT HELENA', 'SHN', 'SH', 0),
        (189, 'SVALBARD AND JAN MAYEN', 'SJM', 'SJ', 0),
        (190, 'SOLOMON ISLANDS', 'SLB', 'SB', 0),
        (191, 'SIERRA LEONE', 'SLE', 'SL', 0),
        (192, 'EL SALVADOR', 'SLV', 'SV', 0),
        (193, 'SAN MARINO', 'SMR', 'SM', 0),
        (194, 'SOMALIA', 'SOM', 'SO', 0),
        (195, 'SAINT PIERRE AND MIQUELON', 'SPM', 'PM', 0),
        (196, 'SAO TOME AND PRINCIPE', 'STP', 'ST', 0),
        (197, 'SURINAME', 'SUR', 'SR', 0),
        (198, 'SLOVAKIA', 'SVK', 'SK', 0),
        (199, 'SLOVENIA', 'SVN', 'SI', 0),
        (200, 'SWEDEN', 'SWE', 'SE', 0),
        (201, 'SWAZILAND', 'SWZ', 'SZ', 0),
        (202, 'SEYCHELLES', 'SYC', 'SC', 0),
        (203, 'SYRIA', 'SYR', 'SY', 0),
        (204, 'TURKS AND CAICOS ISLANDS', 'TCA', 'TC', 0),
        (205, 'CHAD', 'TCD', 'TD', 0),
        (206, 'TOGO', 'TGO', 'TG', 0),
        (207, 'THAILAND', 'THA', 'TH', 0),
        (208, 'TAJIKISTAN', 'TJK', 'TJ', 0),
        (209, 'TOKELAU', 'TKL', 'TK', 0),
        (210, 'TURKMENISTAN', 'TKM', 'TM', 0),
        (211, 'EAST TIMOR', 'TMP', 'TP', 0),
        (212, 'TONGA', 'TON', 'TO', 0),
        (213, 'TRINIDAD AND TOBAGO', 'TTO', 'TT', 0),
        (214, 'TUNISIA', 'TUN', 'TN', 0),
        (215, 'TURKEY', 'TUR', 'TR', 0),
        (216, 'TUVALU', 'TUV', 'TV', 0),
        (217, 'TAIWAN', 'TWN', 'TW', 0),
        (218, 'TANZANIA', 'TZA', 'TZ', 0),
        (219, 'UGANDA', 'UGA', 'UG', 0),
        (220, 'UKRAINE', 'UKR', 'UA', 0),
        (221, 'UNITED STATES MINOR OUTLYING ISLANDS', 'UMI', 'UM', 0),
        (222, 'URUGUAY', 'URY', 'UY', 0),
        (223, 'UNITED STATES', 'USA', 'US', 0),
        (224, 'UZBEKISTAN', 'UZB', 'UZ', 0),
        (225, 'HOLY SEE (VATICAN CITY STATE)', 'VAT', 'VA', 0),
        (226, 'SAINT VINCENT AND THE GRENADINES', 'VCT', 'VC', 0),
        (227, 'VENEZUELA', 'VEN', 'VE', 0),
        (228, 'VIRGIN ISLANDS', 'VGB', '', 0),
        (229, 'VIRGIN ISLANDS 2', 'VIR', '', 0),
        (230, 'VIETNAM', 'VNM', 'VN', 0),
        (231, 'VANUATU', 'VUT', 'VU', 0),
        (232, 'WALLIS AND FUTUNA', 'WLF', 'WF', 0),
        (233, 'SAMOA', 'WSM', 'WS', 0),
        (234, 'YEMEN', 'YEM', 'YE', 0),
        (235, 'YUGOSLAVIA', 'YUG', 'YU', 0),
        (236, 'SOUTH AFRICA', 'ZAF', 'ZA', 0),
        (237, 'ZAMBIA', 'ZMB', 'ZM', 0),
        (238, 'ZIMBABWE', 'ZWE', 'ZW', 0);        ";

       DB::update ($sql);
       $this->command->info('Countries Table' . ' ' . __('Created'));

    }
}
