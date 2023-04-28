<?php

declare(strict_types=1);

namespace Bow\Database\Migration\Shortcut;

use Bow\Database\Migration\SQLGenerator;
use Bow\Database\Exception\SQLGeneratorException;

trait MixedColumn
{
    /**
     * Add boolean column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function addBoolean(string $column, array $attribute = []): SQLGenerator
    {
        return $this->addColumn($column, 'boolean', $attribute);
    }

    /**
    * Add UUID column
    *
    * @param string $column
    * @param array $attribute
    * @return SQLGenerator
    */
    public function addUuid(string $column, array $attribute = []): SQLGenerator
    {
        if (isset($attribute['increment'])) {
            throw new SQLGeneratorException("Cannot define the increment for uuid. You can use addUuidPrimary() instead");
        }

        if (isset($attribute['size'])) {
            throw new SQLGeneratorException("Cannot define size to uuid type");
        }

        if ($this->adapter === "mysql") {
            $attribute['size'] = 36;
            return $this->addColumn($column, 'varchar', $attribute);
        }

        if ($this->adapter === "sqlite") {
            return $this->addColumn($column, 'varchar', $attribute);
        }

        if (!isset($attribute['default']) && $this->adapter === 'pgsql') {
            $attribute['default'] = 'uuid_generate_v4()';
        }

        return $this->addColumn($column, 'uuid', $attribute);
    }

    /**
    * Add UUID column
    *
    * @param string $column
    * @param array $attribute
    * @return SQLGenerator
    */
    public function addUuidPrimary(string $column, array $attribute = []): SQLGenerator
    {
        $attribute['primary'] = true;

        if (isset($attribute['increment'])) {
            throw new SQLGeneratorException("Cannot define the increment for uuid.");
        }

        if (!isset($attribute['default']) && $this->adapter === 'pgsql') {
            $attribute['default'] = 'uuid_generate_v4()';
        }

        return $this->addUuid($column, $attribute);
    }

   /**
    * Add BLOB column
    *
    * @param string $column
    * @param array $attribute
    * @return SQLGenerator
    */
    public function addBinary(string $column, array $attribute = []): SQLGenerator
    {
        return $this->addColumn($column, 'blob', $attribute);
    }

    /**
     * Add ip column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function addIpAddress(string $column, array $attribute = []): SQLGenerator
    {
        return $this->addColumn($column, 'ip', $attribute);
    }

    /**
     * Add mac column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function addMacAddress(string $column, array $attribute = []): SQLGenerator
    {
        return $this->addColumn($column, 'mac', $attribute);
    }

    /**
     * Add enum column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function addEnum(string $column, array $attribute = []): SQLGenerator
    {
        if (!isset($attribute['size'])) {
            throw new SQLGeneratorException("The enum values should be define!");
        }

        if (is_array($attribute['size'])) {
            throw new SQLGeneratorException("The enum values should be array");
        }

        return $this->addColumn($column, 'enum', $attribute);
    }

    /**
     * Add check column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function addCheck(string $column, array $attribute = []): SQLGenerator
    {
        if (!isset($attribute['size'])) {
            throw new SQLGeneratorException("The check values should be define.");
        }

        if (!is_array($attribute['size'])) {
            throw new SQLGeneratorException("The enum values should be array.");
        }

        if (count($attribute['size']) === 0) {
            throw new SQLGeneratorException("The enum values cannot be empty.");
        }

        return $this->addColumn($column, 'check', $attribute);
    }

    /**
     * Change boolean column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function changeBoolean(string $column, array $attribute = []): SQLGenerator
    {
        return $this->changeColumn($column, 'boolean', $attribute);
    }

    /**
     * Change UUID column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function changeUuid(string $column, array $attribute = []): SQLGenerator
    {
        if (isset($attribute['size'])) {
            throw new SQLGeneratorException("Cannot define size to uuid type");
        }

        if ($this->adapter === "mysql") {
            $attribute['size'] = 36;
            return $this->changeColumn($column, 'varchar', $attribute);
        }

        if ($this->adapter === "sqlite") {
            return $this->changeColumn($column, 'varchar', $attribute);
        }

        if (!isset($attribute['default']) && $this->adapter === 'pgsql') {
            $attribute['default'] = 'uuid_generate_v4()';
        }

        return $this->changeColumn($column, 'uuid', $attribute);
    }

    /**
     * Change BLOB column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function changeBinary(string $column, array $attribute = []): SQLGenerator
    {
        return $this->changeColumn($column, 'blob', $attribute);
    }

    /**
     * Change ip column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function changeIpAddress(string $column, array $attribute = []): SQLGenerator
    {
        return $this->changeColumn($column, 'ip', $attribute);
    }

    /**
     * Change mac column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function changeMacAddress(string $column, array $attribute = []): SQLGenerator
    {
        return $this->changeColumn($column, 'mac', $attribute);
    }

    /**
     * Change enum column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function changeEnum(string $column, array $attribute = []): SQLGenerator
    {
        return $this->changeColumn($column, 'enum', $attribute);
    }

    /**
     * Change check column
     *
     * @param string $column
     * @param array $attribute
     * @return SQLGenerator
     */
    public function changeCheck(string $column, array $attribute = []): SQLGenerator
    {
        return $this->changeColumn($column, 'check', $attribute);
    }
}
