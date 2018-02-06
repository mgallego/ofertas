<?php

namespace App\Oauth;

use HWI\Bundle\OAuthBundle\OAuth\Response\AbstractUserResponse;

class UserResponse extends AbstractUserResponse
{
    /**
     * @var array
     */
    protected $paths = [
        'identifier' => 'email',
        'nickname' => 'name',
        'firstname' => 'name',
        'lastname' => 'name',
        'realname' => 'name',
        'email' => 'email',
        'profilepicture' => null,
    ];

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->getValueForPath('identifier');
    }

    /**
     * {@inheritdoc}
     */
    public function getNickname()
    {
        return $this->getValueForPath('nickname');
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName()
    {
        return $this->getValueForPath('firstname');
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName()
    {
        return $this->getValueForPath('lastname');
    }

    /**
     * {@inheritdoc}
     */
    public function getRealName()
    {
        return $this->getValueForPath('realname');
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->getValueForPath('email');
    }

    /**
     * {@inheritdoc}
     */
    public function getProfilePicture()
    {
        return $this->getValueForPath('profilepicture');
    }

    /**
     * Get the configured paths.
     *
     * @return array
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * Configure the paths.
     *
     * @param array $paths
     */
    public function setPaths(array $paths)
    {
        $this->paths = array_merge($this->paths, $paths);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getPath($name)
    {
        return array_key_exists($name, $this->paths) ? $this->paths[$name] : null;
    }

    /**
     * Extracts a value from the response for a given path.
     *
     * @param string $path Name of the path to get the value for
     *
     * @return null|string
     */
    protected function getValueForPath($path)
    {
        $data = $this->data;
        if (!$data) {
            return;
        }

        $steps = $this->getPath($path);
        if (!$steps) {
            $steps = $this->getPath('preferred_username');
            if (!$steps) {
                return;
            }
        }

        if (is_array($steps)) {
            if (1 === count($steps)) {
                return $this->getValue(current($steps), $data);
            }

            $value = [];
            foreach ($steps as $step) {
                $value[] = $this->getValue($step, $data);
            }

            $value = trim(implode(' ', $value));

            return $value ?: null;
        }

        return $this->getValue($steps, $data);
    }

    /**
     * @param string $steps
     * @param array  $response
     *
     * @return null|string
     */
    private function getValue($steps, array $response)
    {
        $value = $response;
        $steps = explode('.', $steps);
        foreach ($steps as $step) {
            if (!array_key_exists($step, $value)) {
                if (array_key_exists('preferred_username', $value)) {
                    return $value['preferred_username'];
                } elseif (array_key_exists('given_name', $value)) {
                    return $value['given_name'];
                } else {
                    return;
                }
            }

            $value = $value[$step];
        }

        return $value;
    }
}
