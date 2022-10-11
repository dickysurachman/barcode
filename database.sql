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