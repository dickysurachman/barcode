create table `barcode_input`(`id` int(11),`nama_file` varchar(150) NULL,`id_perusahaan` int(11) NULL,`barcode` varchar(50),`tanggal` date,
`add_who` int(11) NULL,`edit_who` int(11) NULL,`add_date` datetime NULL, `edit_date` datetime NULL
);

ALTER TABLE `barcode_input`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `barcode_input`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

create table `barcode_retur`(`id` int(11),`status` int(2) DEFAULT 0,`alasan` varchar(200) NULL,`id_perusahaan` int(11) NULL,`barcode` varchar(50),`tanggal` date,
`add_who` int(11) NULL,`edit_who` int(11) NULL,`add_date` datetime NULL, `edit_date` datetime NULL
);

ALTER TABLE `barcode_retur`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `barcode_retur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `scan` ADD INDEX(`barcode`);
ALTER TABLE `barcode_input` ADD INDEX(`barcode`);
ALTER TABLE `barcode_retur` ADD INDEX(`barcode`);


====
ALTER TABLE `scan` ADD INDEX( `id_grup`, `kode`, `tanggal`, `id_perusahaan`);

create table `barcode`(`id` int(11),`barcode` varchar(50),`tanggal` date,
`add_who` int(11) NULL,`edit_who` int(11) NULL,`add_date` datetime NULL, `edit_date` datetime NULL
);
ALTER TABLE `barcode`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `barcode`
  ADD KEY (`barcode`);
ALTER TABLE `barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
=======

alter table `barcode` add id_perusahaan int(11) NULL;
delete from kurir WHERE id_perusahaan=4;
delete from grup WHERE id_perusahaan=4;
alter table `perusahaan` add limitan int(3) DEFAULT 1;
TRUNCATE scan;
TRUNCATE inputan;
TRUNCATE barcode;
TRUNCATE barcode_input;
TRUNCATE barcode_retur;

============
create table `contact`(`id` int(11),`name` varchar(100) NULL,`tanggal` datetime DEFAULT current_timestamp(),
`email` varchar(100) NULL, `subjek` varchar(150) NULL,`isi` text null,`id_perusahaan` int(11) NULL
);
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
=================
alter table `contact` add status int(2) DEFAULT 0;
alter table `perusahaan` add expiredate date NULL; 
update `perusahaan` set expiredate=DATE_ADD(now(), INTERVAL 7 DAY);
=============================
alter table `contact` add barcode varchar(20) NULL;

===================================
alter table `perusahaan` add serialkey varchar(80) NULL; 
alter table `inputan` add `ip` varchar(80) NULL; 
ALTER TABLE `perusahaan` ADD INDEX(`serialkey`);