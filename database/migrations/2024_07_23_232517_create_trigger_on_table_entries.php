<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Her kullanıcı için entry sayısı ve son entry maliyetinden kurtulmanın en güzel yolu kaydederken bu işi çözmek
     * Kayıt işlemini larevel observer ile yapmamamın sebebi db'nin kayıt işlemini çok daha hızlı yapacağıdır
     * Ayrıca olası herhangi bir problemde de db tarafı muhatap olacak
     * Bu sebeple dbye trigger yazdırmak çok daha iyi bir seçim olacak
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER new_entry_for_user AFTER INSERT ON entries FOR EACH ROW
            BEGIN
                UPDATE users
                SET entry_count = entry_count + 1,
                last_entry = concat(NEW.subject, " | ", NEW.message)
                WHERE users.id = NEW.user_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update('DROP TRIGGER new_entry_for_user ON entries;');
    }
};
