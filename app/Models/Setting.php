<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Cache seluruh pengaturan per-request agar tidak query berulang. */
    protected static ?array $cache = null;

    /** Ambil satu nilai pengaturan berdasarkan key (memakai cache in-memory). */
    public static function get($key, $default = null)
    {
        if (static::$cache === null) {
            try {
                static::$cache = static::query()->pluck('value', 'key')->all();
            } catch (\Throwable $e) {
                // Tabel belum ada (mis. sebelum migrate) -> jangan sampai gagal.
                static::$cache = [];
                return $default;
            }
        }

        return array_key_exists($key, static::$cache) ? static::$cache[$key] : $default;
    }

    /** Simpan / perbarui nilai pengaturan sekaligus menyinkronkan cache. */
    public static function put($key, $value)
    {
        $row = static::updateOrCreate(['key' => $key], ['value' => $value]);

        if (is_array(static::$cache)) {
            static::$cache[$key] = $value;
        }

        return $row;
    }
}
