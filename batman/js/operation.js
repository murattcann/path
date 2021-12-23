 
$(function() {

    const BATMAN_LIST_URL = "https://www.cheapshark.com/api/1.0/games?title=batman";
    const BASE_DEAL_ID_URL = "https://www.cheapshark.com/api/1.0/deals?id=";
    var games = [];
    var gamesPrices = [];
    
    function getGameList(limit = 60){
        $.ajax({
                headers: { "Accept": "application/json"},
                type: 'GET',
                url: BATMAN_LIST_URL+"&limit="+limit,
                crossDomain: true,
                beforeSend: function(xhr){
                    xhr.withCredentials = true;
                },
                success: function(data, textStatus, request){
                    $.each(data, function (index, value) {
                        let gameVal = value;

                        $.ajax({
                            headers: { "Accept": "application/json"},
                            type: 'GET',
                            url: BASE_DEAL_ID_URL+value.cheapestDealID,
                            crossDomain: true,
                            beforeSend: function(xhr){
                                xhr.withCredentials = true;
                            },
                            success: function(priceData, textStatus, request){

                                let gameInfo = priceData.gameInfo;
                                let discountRatio = 100-(gameInfo.salePrice*100/gameInfo.retailPrice);

                                gameVal["currentPrice"] = gameInfo.salePrice; 
                                gameVal["oldPrice"] = gameInfo.retailPrice; 
                                gameVal["discountRatio"] = discountRatio; 

                                games.push(gameVal);

                            }
                        });

                       
                    });
                }
        });
    }

    function parseData(data) {
        if (!data) return {};
        if (typeof data === 'object') return data;
        if (typeof data === 'string') return JSON.parse(data);

        return {};
    }
    getGameList();
   
    let html ='';
    let gamePrices = [];
    setTimeout(function(){
    
        $.each(games, function (gameIndex, gameValue) {

            let discountInfo = `<span class="discount position-absolute badge badge-info">% ${parseInt(gameValue.discountRatio)}</span>`;
            let oldPrice = gameValue.discountRatio > 0 ? "$" + gameValue.oldPrice : '';
            if(gameValue.discountRatio <= 0) discountInfo = '';

            html +=  `
                <div class="col-md-3">
                    <div class="card listingCard mt-2 position-relative">
                        ${discountInfo}
                        <img src="${gameValue.thumb}" class="card-img-top" alt="pizza">
                        <div class="card-body">
                        <h5 class="card-title">${gameValue.external}</h5>
                        <p class="card-text">${gameValue.external} hakkında açıklama</p>
                        <div class="card-footer">
                            <span class="price">
                                $${gameValue.currentPrice}
                            </span>
                            <span class="oldPrice">
                                ${oldPrice}
                            </span>
                        </div>
                        </div>
                    </div>
                </div>
            `;
        });
       
        $("#listingRow").append(html);
      
    }, 1000);
}); 