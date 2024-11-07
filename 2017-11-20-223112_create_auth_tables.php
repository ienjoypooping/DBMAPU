<?php

namespace Myth\Auth\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuthTables extends Migration
{
    public function up()
    {
        // Users Table
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'            => ['type' => 'varchar', 'constraint' => 255],
            'username'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'password_hash'    => ['type' => 'varchar', 'constraint' => 255],
            'reset_hash'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'reset_at'         => ['type' => 'datetime', 'null' => true],
            'reset_expires'    => ['type' => 'datetime', 'null' => true],
            'activate_hash'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'           => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'force_pass_reset' => ['type' => 'tinyint', 'constraint' => 1, 'default' => 0],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users', true);

        // Auth Logins Table
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'date'       => ['type' => 'datetime'],
            'success'    => ['type' => 'tinyint', 'constraint' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->addKey('user_id');
        $this->forge->createTable('auth_logins', true);

        // Auth Tokens Table
        $this->forge->addField([
            'id'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'selector'        => ['type' => 'varchar', 'constraint' => 255],
            'hashedValidator' => ['type' => 'varchar', 'constraint' => 255],
            'user_id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'expires'         => ['type' => 'datetime'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('selector');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('auth_tokens', true);

        // Password Reset Table
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_reset_attempts', true);

        // Activation Attempts Table
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'ip_address' => ['type' => 'varchar', 'constraint' => 255],
            'user_agent' => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_activation_attempts', true);

        // Groups Table
        $this->forge->addField([
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_groups', true);

        // Permissions Table
        $this->forge->addField([
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 255],
            'description' => ['type' => 'varchar', 'constraint' => 255],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_permissions', true);

        // Groups/Permissions Table
        $this->forge->addField([
            'group_id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);
        $this->forge->addKey(['group_id', 'permission_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', '', 'CASCADE');
        $this->forge->createTable('auth_groups_permissions', true);

        // Users/Groups Table
        $this->forge->addField([
            'group_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'user_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);
        $this->forge->addKey(['group_id', 'user_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('auth_groups_users', true);

        // Users/Permissions Table
        $this->forge->addField([
            'user_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'permission_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ]);
        $this->forge->addKey(['user_id', 'permission_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', '', 'CASCADE');
        $this->forge->createTable('auth_users_permissions', true);

        // Tabel Penambahan Aset
        $this->forge->addField([
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_barang'      => ['type' => 'varchar', 'constraint' => 255],
            'merk'             => ['type' => 'varchar', 'constraint' => 255],
            'type'             => ['type' => 'varchar', 'constraint' => 255],
            'tahun_pembuatan'  => ['type' => 'int', 'constraint' => 4],
            'no_bpkb'          => ['type' => 'varchar', 'constraint' => 255],
            'no_stnk'          => ['type' => 'varchar', 'constraint' => 255],
            'kondisi'          => ['type' => 'varchar', 'constraint' => 255],
            'no_sk_psp'        => ['type' => 'varchar', 'constraint' => 255],
            'no_polisi'        => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'delete_at'        => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('penambahan_aset', true);

        // Tabel Peminjaman
        $this->forge->addField([
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'surat_permohonan'  => ['type' => 'varchar', 'constraint' => 255], // untuk upload PDF
            'surat_jalan'       => ['type' => 'varchar', 'constraint' => 255], // untuk upload PDF
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'delete_at'         => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman', true);

        // Tabel Pengembalian
        $this->forge->addField([
            'id'                       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'peminjaman_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'berita_acara_pengembalian' => ['type' => 'varchar', 'constraint' => 255], // untuk upload PDF
            'created_at'               => ['type' => 'datetime', 'null' => true],
            'updated_at'               => ['type' => 'datetime', 'null' => true],
            'delete_at'                => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('peminjaman_id', 'peminjaman', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengembalian', true);
    }

    public function down()
    {
        // Drop tables in reverse order to avoid foreign key constraint issues
        $this->forge->dropTable('pengembalian', true);
        $this->forge->dropTable('peminjaman', true);
        $this->forge->dropTable('penambahan_aset', true);
        $this->forge->dropTable('auth_users_permissions', true);
        $this->forge->dropTable('auth_groups_users', true);
        $this->forge->dropTable('auth_groups_permissions', true);
        $this->forge->dropTable('auth_permissions', true);
        $this->forge->dropTable('auth_groups', true);
        $this->forge->dropTable('auth_activation_attempts', true);
        $this->forge->dropTable('auth_reset_attempts', true);
        $this->forge->dropTable('auth_tokens', true);
        $this->forge->dropTable('auth_logins', true);
        $this->forge->dropTable('users', true);
    }
}
