#include "modell_modell.h"
#include <stdlib.h>
#include <time.h>
#include <cmath>

//-----VisitorInfo-----//

VisitorInfo::VisitorInfo(float hl, float md, int mny, int tl, int paf, VisitorState s):
    hungerlevel(hl), mood(md), money(mny), toalettLevel(tl), prefAdrFactor(paf), state(s)
{}

//-------Visitor-------//

Visitor::Visitor(Modell& m){
    srand (time(NULL));
    x=19; //ide veszem egyelore a bejaratot, es minden uj latogato itt jon be
    y=13; //ide veszem egyelore a bejaratot, es minden uj latogato itt jon be
    hungerLevel = rand() % 71; //between 0 and 70
    mood = rand() % 21 + 80; //between 80 and 100
    money=rand() % 61 + 40; //between 40 and 100
    //coupon =
    toalettLevel = rand() % 71; //between 0 and 70
    prefAdrFactor = rand() % 100 + 1; //between 1 and 100
    state = noDest;
    visitor_id = m.next_visitor_id++;
    m.newVisitor(visitor_id);
}

bool Visitor::next_to_it(){
    int destX = destination->getX();
    int destY = destination->getY();
    /*return (x == destX && (y+1 == destY || y-1 == destY)) ||
           (y == destY && (x+1 == destX || x-1 == destX));*/
    return abs(destX-x) <= 1 && abs(destY-y) <= 1;
}

bool Visitor::useService(Modell& m){
    if (pay(m, destination)){
        state=waiting;
        destination->stand_in_line(this);
    }
    else{
        state=leaving;
//        destination = static_cast<Place*>(m.getField()[19][13]);
        return false;
    }
}

void Visitor::enterPark(Modell& m){
    pay(m, nullptr); //pay for entering
    chooseDestination(m);
    //state=movingToDest;
}

bool Visitor::pay(Modell& m, Place* place){
    //call with nullptr to pay for entering
    int price = place == nullptr ? m.getTicketPrice() : place->getPrice();
    if (money - price >= 0)
        money -= price;
    else
        return false;
    m.addToAssets(price);
    return true;
}

void Visitor::chooseDestination(Modell& m){


//prioritasi sorrend: mood->hunger->toalett->(x, y)

    if(state==leaving){
            this->destination = static_cast<Place*>(m.getField().at(19).at(13));
    }
    else if(this->getMood()<45){
        while(state != movingToDest){
            int randIndex = rand()%m.getGames()->size();
            if(isGame(m.getGames()->at(randIndex)->getType()) &&
                    m.getGames()->at(randIndex)->getAdrFactor()+10 >= prefAdrFactor || m.getGames()->at(randIndex)->getAdrFactor()+10<= prefAdrFactor ||
                    m.getGames()->at(randIndex)->getAdrFactor()-10 >= prefAdrFactor || m.getGames()->at(randIndex)->getAdrFactor()-10<= prefAdrFactor){
                destination = m.getGames()->at(randIndex);
                state = movingToDest;
            }
        }


    }
    else if(this->getHunger()>50){
        while(state != movingToDest){
            int randIndex = rand()%m.getPlaces()->size();
            if(isFoodPlace(m.getPlaces()->at(randIndex)->getType())){
                destination = m.getPlaces()->at(randIndex);
                state = movingToDest;
            }
            else {
                std::vector<Place*>* helyek = m.getPlaces();
                int randIndex = rand()%helyek->size();
                if(helyek->at(randIndex)->getType()!=ItemType::toilet){
                    destination = helyek->at(randIndex);
                    state = movingToDest;

                }
                else{
                    randIndex = rand()%helyek->size();
                    destination = helyek->at(randIndex);
                    state = movingToDest;

                }
            }
        }
    }
    else if (this->getToalettLevel()>35){
        while(state != movingToDest){
            int randIndex = rand()%m.getPlaces()->size();
            if(isToilet(m.getPlaces()->at(randIndex)->getType())){
                destination = m.getPlaces()->at(randIndex);
                state = movingToDest;

            }
            else {
                std::vector<Place*>* helyek = m.getPlaces();
                int randIndex = rand()%helyek->size();
                if(helyek->at(randIndex)->getType()!=ItemType::toilet){
                    destination = helyek->at(randIndex);
                    state = movingToDest;


                }
                else{
                    randIndex = rand()%helyek->size(); //FB:csokkentem az eselyt, hogy veletlen a wc-t valassza
                    destination = helyek->at(randIndex);
                    state = movingToDest;


                }

            }
        }
    }

    else {
        std::vector<Place*>* helyek = m.getPlaces();
        int randIndex = rand()%helyek->size();
        destination = helyek->at(randIndex);
        state = movingToDest;
    }



    int cols = 26;
    int rows = 20;
    int** a = new int*[rows+1];
        for (int i = 0; i <= rows ; i++) {
            a[i] = new int[cols+1];

        }
        for (int i = 0  ; i <= rows ; ++i) {
            for (int j = 0; j <= cols ; ++j) {
               a[i][j] = 0;

            }
        }
        //kerites
            for (int i = 0  ; i <= cols ; ++i) {
                a[0][i]=2;
                a[rows][i]=2;
            }
            for (int i = 0  ; i <= rows ; ++i) {
                a[i][0]=2;
                a[i][cols]=2;
            }

        //akadalyok
            for(int i = 1; i < rows; i++){
                for(int j = 1; j < cols; j++){
                     a[i][j] = 1;

                }
            }
            for(auto item : *m.getRoads()){
                a[item->getX()][item->getY()] = 0;
            }


        //actualis hely
        int actPosX = this->x;
        int actPosY = this->y;
        //destination hely
        int destX = this->destination->getX();
        int destY = this->destination->getY();
//        a[actPosX][actPosY] = 0;
        a[destX][destY] = 0;
        QPair<int, int>*pathA = new QPair<int, int>[cols];
        QPair<int, int>*pathMin = new QPair<int, int>[cols];
        int kmin = cols*rows;
        findPath(a, pathA, pathMin, &kmin, destX, destY, actPosX, actPosY, 0 );
//        qDebug()<< actPosX<<" "<<actPosY<<" "<< destX<< " "<<destY;
        QVector<QPair<int,int>> *temp = new QVector<QPair<int,int>>[kmin+1];
        path.clear();
        for(int i = 1; i < kmin; ++i){
//            qDebug()<<kmin<< " ("<<pathMin[i].first<<", "<< pathMin[i].second<<") --> ";
            path.push_back( pathMin[i]);

        }

}

void Visitor::moveTowardsDest(Modell& m){
    if(path.size()>=200){ //TODO: lowbudget megoldas lecserelese
        chooseDestination(m);
    }
    else{
        x = path.at(0).first;
        y = path.at(0).second;
        path.pop_front();
    }


//    qDebug() << "x: " << x << ",y: " << y;
//    m.errorMessage("x: " + QString::number(x) + ",y: " + QString::number(y) );
}


void Visitor::leavePark(Modell& m){

}

void Visitor::updateVisitor(Modell& m){
    if (state == noDest){
        chooseDestination(m);
    }
    if (state == waiting){
        setMood(mood-0.5);
    }
    if (state == usingService)
        setMood(mood+2);

    if (state == leaving){
        if (next_to_it()){
            state=VisitorState::left_park;
            x = destination->getX();
            y = destination->getY();
        }
        else{
//            chooseDestination(m);
            moveTowardsDest(m);
        }
    }

    if (state == movingToDest){
        if (next_to_it() && useService(m)){
            x = destination->getX();
            y = destination->getY();
//            useService(m);
        }
        else if(state == leaving){
            chooseDestination(m);
        }
        else
            moveTowardsDest(m);
    }


    /*if (state == leaving && next_to_it()){
        state=VisitorState::left;
    }*/
    setHunger(hungerLevel + 0.3);
    setMood(mood - 0.2);
    setToalett(toalettLevel + 0.2);
    if (hungerLevel < 15){
        setMood(mood - 0.8);
    }
    /*if (mood == 0){
        destination = static_cast<Place*>(m.getField()[19][13]);
    }*/
    if ((int)mood == 0 || (int)money == 0){
        state = leaving;
        chooseDestination(m);
        //destination = static_cast<Place*>(m.getField()[19][13]);
    }
    if (((int)mood == 0 || (int)money == 0) && state == leaving && x == 19 && y == 13){
        state = VisitorState::left_park;
    }
    if(destination->getType()==ItemType::toilet && x==destination->getX() && y==destination->getY()){
        setToalett(this->getToalettLevel()-30);
        chooseDestination(m);
    }


    //plants boost mood

    /*if(isPlant(m.getField().at((this->x+1)%19).at(this->y)->getType()) ||
       isPlant(m.getField().at(this->x).at((this->y+1)%25)->getType()) ||
       isPlant(m.getField().at(abs(this->x-1)).at(this->y)->getType()) ||
       isPlant(m.getField().at(this->x).at(abs(this->y-1))->getType())){

        setMood(mood + 0.4); // ha elmegy mellette akkor boldogabb lesz

    }*/

}

void Visitor::findPath(int **a, QPair<int, int> *ut, QPair<int, int> *utmin, int *kmin, int xs, int ys, int ax, int ay, int k)
{
//    a[xs][ys] = 0;
    ut[k].first = ax;
    ut[k].second = ay;
        if(ax == xs && ay == ys){
            if (k < *kmin){
                *kmin = k;
                for (int i = 1; i <= k ; ++i) {
                    utmin[i] = ut[i];
                }
            }
        }
        else{
            a[ax][ay] = 1;
            if (a[ax-1][ay] == 0){
                findPath(a, ut, utmin, kmin, xs, ys, ax-1, ay, k+1);
            }
            if (a[ax][ay-1] == 0){
                findPath(a, ut, utmin, kmin, xs, ys, ax, ay-1, k+1);
            }
            if (a[ax+1][ay] == 0){
                findPath(a, ut, utmin, kmin, xs, ys, ax+1, ay, k+1);
            }
            if (a[ax][ay+1] == 0){
                findPath(a, ut, utmin, kmin, xs, ys, ax, ay+1, k+1);
            }
            a[ax][ay] = 0;
        }
}

/*void Visitor::clickVisitor(){
    VisitorStateInfo(VisitorInfo(hungerLevel,mood,money,toalettLevel,prefAdrFactor,state));
}*/

