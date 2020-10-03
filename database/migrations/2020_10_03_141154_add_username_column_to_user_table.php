<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsernameColumnToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('email')->nullable();
        });
        // create default user name for the current users
        $allUsers = User::all();
        foreach ($allUsers as $user){
            if ($user->getRole()->name == 'user'){
                $id = $user->id;
                $user->username = "STU" .  str_pad($id, 5, '0', STR_PAD_LEFT);
                $user->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
}
