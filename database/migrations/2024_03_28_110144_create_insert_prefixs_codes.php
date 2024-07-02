<?php

use App\Models\PrefixCode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $phpCode = '<?php $connection = new mysqli("localhost", "root", "test", "webhook") or die("Connect failed: %s\n". $connection->error);';
        $data = new PrefixCode;
        $data->name = 'CONNECTION_CODE';
        $data->code = encrypt($phpCode);
        $data->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        PrefixCode::where('id',1)->delete();
    }
};
