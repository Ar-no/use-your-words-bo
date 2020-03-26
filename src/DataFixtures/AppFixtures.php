<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Scene;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $videos = [
            'https://www.youtube.com/watch?v=RLMC0d7Szok',
            'https://www.youtube.com/watch?v=J53UK_bul5Y',
            'https://www.youtube.com/watch?v=ee925OTFBCA',
            'https://www.youtube.com/watch?v=umDr0mPuyQ',
            'https://www.youtube.com/watch?v=vxKBHX9Datw',
            'https://www.youtube.com/watch?v=_4-MmsLKRDw',
            'https://www.youtube.com/watch?v=RM88KhLw0oA',
            'https://www.youtube.com/watch?v=mFElmSV87pg',
            'https://www.youtube.com/watch?v=wr6H7W9Z_oE',
            'https://www.youtube.com/watch?v=pJIunF3TXtc'
        ];
        foreach($videos as $v){
            $s = new Scene();
            $s->setUrl($v);
            $manager->persist($s);
        }

        $manager->flush();
    }
}
