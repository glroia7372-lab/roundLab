<?php
// index.php
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROUND LAB - 사진과 똑같은 디자인</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* --- 기본 설정 --- (생략 없이 원본 유지) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans KR', sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f7f9fc; /* 전체 배경색 */
            overflow-x: hidden; 
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* --- Header --- (생략 없이 원본 유지) */
        header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 0.5rem 5%;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 5px rgba(0,0,0,0.05); /* 사진에 보이는 그림자 */
            animation: fadeInDown 0.6s ease-out;
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            /* 📌 수정: 햄버거 메뉴 대응을 위해 space-between 유지 */
            justify-content: space-between;
            align-items: center;
            height: 50px;
        }

        .logo {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: #333;
            letter-spacing: 0.5px;
        }

        /* 📌 햄버거 메뉴 토글 버튼 (기본 숨김) */
        .menu-toggle {
            display: none; 
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.05rem;
            color: #666;
            transition: color 0.3s;
            z-index: 1001;
            margin-left: 1rem;
        }

        .nav {
            display: flex;
            gap: 2.2rem;
            list-style: none;
            margin: 0;
        }

        .nav a {
            font-size: 0.95rem;
            font-weight: 600;
            color: #666;
            transition: color 0.3s;
        }
        .nav a:hover {
            color: #333;
        }

        .header-icons {
            display: flex;
            gap: 1.0rem;
            align-items: center;
        }

        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.05rem;
            color: #666;
            transition: color 0.3s;
        }
        .icon-btn:hover {
            color: #333;
        }

        /* --- Main Banner --- (생략 없이 원본 유지) */
        .main-banner {
            background-color: #e3f2fd; /* 사진의 배경색 (블루 계열) */
            border-radius: 20px; /* 사진과 동일한 둥근 모서리 */
            margin: 2rem 3%; /* 사진과 동일한 여백 */
            position: relative;
            overflow: hidden;
            min-height: 600px; /* 사진과 동일한 높이 */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* 사진과 동일한 그림자 */
            border: 1px solid rgba(255, 255, 255, 0.8); /* 사진 외곽선 */
            height: 800px;
        }

        .banner-background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            filter: brightness(0.95) contrast(1.05); /* 사진 이미지의 필터 */
            opacity: 0.98; /* 사진과 동일한 투명도 */
            animation: zoomInFade 3s ease-out forwards;
        }
        
        @keyframes zoomInFade {
            from { opacity: 0.5; transform: scale(1.05); }
            to { opacity: 0.98; transform: scale(1); }
        }

        @keyframes ripple {
            0% { box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); }
            50% { box-shadow: 0 0 0 30px rgba(255, 255, 255, 0.1); }
            100% { box-shadow: 0 0 0 60px rgba(255, 255, 255, 0); }
        }

        .banner-content {
            z-index: 5;
            position: absolute;
            top: 25%; /* 사진과 동일한 위치 */
            left: 30px; /* 사진과 동일한 위치 */
            text-align: left;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3); /* 사진과 동일한 그림자 */
        }

        .banner-label {
            font-size: 0.8rem; /* 사진과 동일한 크기 */
            font-weight: 500;
            margin-bottom: 0.8rem; /* 사진과 동일한 여백 */
            letter-spacing: 0.5px;
            opacity: 0.8;
            color: black; /* 사진과 동일한 텍스트 색상 */
        }

        .banner-title {
            font-size: 2.8rem; /* 사진과 동일한 크기 */
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 1.5rem;
            color: white; /* 사진과 동일한 텍스트 색상 */
        }

        /* 좌측 하단 제품 카드 */
        .banner-product-card {
            z-index: 5;
            position: absolute;
            left: 30px;
            bottom: 30px; /* 사진과 동일한 위치 */
            background: rgba(255, 255, 255, 0.85); /* 사진과 동일한 투명 배경 */
            padding: 1.2rem 1.8rem; /* 사진과 동일한 패딩 */
            border-radius: 30px; /* 사진과 동일한 둥근 모서리 */
            display: flex;
            align-items: center;
            gap: 0.5rem; /* 사진과 동일한 간격 */
            backdrop-filter: blur(5px); /* 사진과 동일한 블러 효과 */
            min-width: 380px; /* 사진과 유사한 너비 */
            /* transition: transform 0.3s ease, box-shadow 0.3s ease; */
        }
        .banner-product-card:hover {
            transform: translateY(-5px); 
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25); 
        }

        .product-card-image {
            width: 80px; /* 사진과 동일한 크기 */
            height: 80px; /* 사진과 동일한 크기 */
            background: #f8fcfd; /* 사진과 동일한 배경색 */
            border-radius: 10px; /* 사진과 동일한 둥근 모서리 */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid #eef; /* 사진 외곽선 */
            
        }
        
        .product-card-image img {
            width: 60%; /* 사진과 동일한 이미지 크기 */
            height: auto;
            object-fit: contain;
        }

        .product-card-info {
            color: #333;
            text-align: left;
        }

        .product-card-name {
            font-size: 0.85rem; /* 사진과 동일한 크기 */
            font-weight: 500;
            margin-bottom: 0.1rem;
        }

        .product-card-price {
            font-size: 1.1rem; /* 사진과 동일한 크기 */
            font-weight: 700;
        }

        /* 우측 중앙 제품 영역 */
        .banner-right-section {
            position: absolute;
            right: 30px; /* 사진과 동일한 위치 */
            bottom: 30px;
            z-index: 5;
            
            /* 사진 속 투명한 파란색 박스 스타일 */
            background: rgba(255, 255, 255, 0.15); /* 매우 옅은 투명 배경 */
            backdrop-filter: blur(10px);
            
            
            border-radius: 30px;
            padding: 0.5rem; /* 내부 여백 조정 */
            
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* 내부 요소를 중앙 정렬 */
            gap: 0.8rem; /* 요소 간 간격 조정 */
            /* box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1); */
            
            /* 크기 고정 (사진과 유사하게) */
            width: 300px;
        }

        .banner-right-section:hover {
            transform: translateY(-5px); 
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25); 
        }

        .banner-product-label {
            /* 배경 컨테이너가 이미 투명 배경을 가지고 있으므로, 라벨은 배경/그림자 제거 */
            background: none; 
            padding: 5px;
            border-radius: 0;
            font-size: 0.8rem; 
            color: white; /* 텍스트 색상 변경 (사진의 흰색 텍스트와 유사하게) */
            font-weight: 500;
            line-height: 1.4;
            text-align: left;
            backdrop-filter: none;
            border: none;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3); /* 그림자 추가 */
        }

        .banner-image {
            width: 100%; /* 부모 컨테이너(200px)에 맞춤 */
            height: 250px; /* 높이 조정 */
            background: white; /* 흰색 배경 */
            border-radius: 30px; /* 사진과 동일한 둥근 모서리 */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
            
            /* 이 요소 자체가 흰색이므로 가짜 ::before 배경 제거 */
            backdrop-filter: none;
            border: none;
        }
        .banner-image:hover {
            transform: none; /* 컨테이너에 애니메이션을 적용하지 않음 */
        }

        .banner-image img {
            width: 80%; /* 이미지 크기 조정 */
            height: auto;
            object-fit: contain;
            z-index: 2;
        }

        /* 기존 .banner-image::before 스타일 제거 (이 요소 자체가 흰색 배경이 되었으므로) */
        .banner-image::before { /* 사진의 흰색 제품 배경 */
            content: none;
        }

        /* 상세 버튼 (흰색 배경 컨테이너 밖으로 빼서 중앙에 배치) */
        .banner-detail-btn {
            width: 55px; /* 사진과 유사한 크기 */
            height: 55px; /* 사진과 유사한 크기 */
            background: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: black;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            
            /* 사진과 동일하게 오른쪽 상단에 배치하는 방식으로 변경 (CSS로 위치 조정) */
            position: absolute;
            top: 10px; 
            right: 10px; 
            /* transform: translate(30%, -30%);  */
            /* 사진처럼 살짝 밖으로 나오게 조정 */
            z-index: 10;
        }
        .banner-detail-btn:hover {
            /* transform: scale(1.08) rotate(5deg);
            box-shadow: 0 7px 20px #5b9bd5; */
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.8);
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        /* --- Products Section (Best/Set/Sale) --- (생략 없이 원본 유지) */
        .products-section {
            max-width: 1400px;
            margin: 5rem auto 3rem auto;
            padding: 0 3%;
        }

        .section-header {
            display: flex;
            gap: 2rem; /* 사진과 동일한 간격 */
            margin-bottom: 2.5rem; /* 사진과 동일한 여백 */
        }

        .section-tab {
            padding: 0;
            font-size: 2.5rem; /* 사진과 동일한 크기 */
            font-weight: 380;
            color: #ccc;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }
        .section-tab.active {
            color: #333; /* 사진과 동일한 활성 색상 */
        }
        .section-tab::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -6px; /* 사진과 동일한 위치 */
            width: 0;
            height: 3px; /* 사진과 동일한 두께 */
            background-color: #5b9bd5;
            transition: width 0.3s ease-out;
        }
        .section-tab.active::after {
            width: 100%;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem; /* 사진과 동일한 간격 */
            max-width: 1100px;
        }

        .product-card {
            background: rgba(255, 255, 255, 20%); /* 사진과 동일한 배경색 */
            border-radius: 50px; /* 사진과 동일한 둥근 모서리 */
            padding: 1.2rem; /* 사진과 동일한 패딩 */
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); /* 사진과 동일한 그림자 */
            cursor: pointer;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 350px; /* 사진과 동일한 높이 */
            background: white; /* 사진과 동일한 배경색 */
            border-radius: 50px; /* 사진과 동일한 둥근 모서리 */
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 0.8rem; /* 사진과 동일한 여백 */
            overflow: hidden;

        }
        
        .product-image img {
            width: 70%;
            height: auto;
            object-fit: contain;
            z-index: 2;
        }
        
        .product-image::before {
            content: '';
            width: 70px; /* 사진과 유사한 크기 */
            height: 180px;
            background: white; /* 사진과 동일한 배경색 */
            border-radius: 30px;
            position: absolute;
            z-index: 1;
        }

        .product-name {
            font-size: 0.9rem; /* 사진과 동일한 크기 */
            font-weight: 500;
            line-height: 1.3;
            color: #333;
        }

        .product-price {
            font-size: 1.1rem; /* 사진과 동일한 크기 */
            font-weight: 700;
            color: #333;
            margin-top: 0.2rem;
        }

        .add-to-cart-btn {
            position: absolute;
            bottom: 1.2rem; /* 사진과 동일한 위치 */
            right: 1.2rem; /* 사진과 동일한 위치 */
            background: white;
            border: 1px solid white;
            width: 55px; /* 사진과 동일한 크기 */
            height: 55px; /* 사진과 동일한 크기 */
            border-radius: 50%;
            font-size: 0.9rem; /* 사진과 동일한 크기 */
            color: #5b9bd5;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .add-to-cart-btn:hover {
            transform: scale(1.05);
            background: #5b9bd5;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* --- Recommendation Section (피부가 좋아지는 화장품) --- (생략 없이 원본 유지) */
        .recommendation-section {
            max-width: 1400px;
            margin: 5rem auto;
            padding: 0 3%;
        }

        .recommendation-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 2.5rem; /* 사진과 동일한 여백 */
        }

        .recommendation-banner {
            position: relative;
            border-radius: 1000px;
            overflow: hidden;
            min-height: 500px; /* 사진과 동일한 높이 */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* 사진과 동일한 그림자 */
            border: none;
        }

        .recommendation-background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            filter: brightness(0.9); /* 사진과 동일한 밝기 */
        }

        .product-image-large {
            position: absolute;
            left: 0%;
            top: 10%;
            transform: translateY(-50%);
            width: 100%; /* 사진과 동일한 크기 */
            height: 100%; /* 사진과 동일한 크기 */
            background: transparent;
            display: flex;
            align-items: center;
            
            z-index: 2;
            transition: transform 0.3s ease;
        }
        .product-image-large:hover {
            transform: translateY(-50%) scale(1.02);
        }
        .product-image-large img {
            width: 60%; 
            height: auto; 
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            
            object-fit: contain;
        }

        .recommendation-badge {
            position: absolute;
            right: 25%; /* 사진과 동일한 위치 */
            top: 35%;
            transform: translateY(-50%);
            text-align: left;
            color: white;
            z-index: 3;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3); /* 사진과 동일한 그림자 */
        }

        .badge-mini {
            font-size: 1rem; /* 사진과 동일한 크기 */
            font-weight: 500;
        }

        .badge-title {
            font-size: 2.5rem; /* 사진과 동일한 크기 */
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0.3rem;
        }

        .badge-subtitle {
            font-size: 1.5rem; /* 사진과 동일한 크기 */
            font-weight: 500;
        }

        /* --- CTA Grid Section --- (생략 없이 원본 유지) */
        .cta-section {
            max-width: 1400px;
            margin: 4rem auto;
            padding: 0 3%;
        }

        .cta-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem; /* 사진과 동일한 간격 */
        }

        .cta-card {
            background: linear-gradient(135deg, #a0d8ed 0%, #7db9d6 100%); /* 사진과 동일한 그라데이션 */
            border-radius: 20px;
            padding: 2.5rem; /* 사진과 동일한 패딩 */
            color: white;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .cta-card:nth-child(2) {
            background: linear-gradient(135deg, #8bc9e2 0%, #6899b5 100%); /* 사진과 동일한 그라데이션 */
        }
        .cta-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .cta-card h3 {
            font-size: 1.8rem; /* 사진과 동일한 크기 */
            font-weight: 700;
            margin-bottom: 0.8rem;
        }

        .cta-arrow {
            width: 35px; /* 사진과 동일한 크기 */
            height: 35px; /* 사진과 동일한 크기 */
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem; /* 사진과 동일한 크기 */
            margin-top: 0.8rem;
            transition: background 0.3s, color 0.3s;
        }
        .cta-card:hover .cta-arrow {
            background: white;
            color: #5b9bd5;
        }

        /* --- Footer --- (생략 없이 원본 유지) */
        footer {
            background: #fff;
            border-top: 1px solid #e0e0e0;
            padding: 2.5rem 5%; /* 사진과 동일한 패딩 */
            margin-top: 3rem; /* 사진과 동일한 여백 */
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid; /* flex에서 grid로 변경하여 컬럼 레이아웃 적용 */
            grid-template-columns: 1.5fr 1fr 1.5fr; /* 사진과 동일한 컬럼 비율 */
            gap: 2rem; /* 사진과 동일한 간격 */
        }

        .footer-section h4 {
            font-size: 0.95rem; /* 사진과 동일한 크기 */
            font-weight: 700;
            margin-bottom: 0.8rem; /* 사진과 동일한 여백 */
            color: #333;
        }

        .footer-section p,
        .footer-section a {
            font-size: 0.8rem; /* 사진과 동일한 크기 */
            color: #777; /* 사진과 동일한 색상 */
            line-height: 1.5;
            margin-bottom: 0.4rem;
            display: block; /* a 태그가 한 줄을 차지하도록 */
        }
        .footer-section a:hover {
            color: #5b9bd5;
        }

        /* =======================================
        📌 수정된 반응형 (RWD) 영역 
        =======================================
        */
        @media (max-width: 1200px) {
            /* 1200px 이하일 때, 데스크톱 레이아웃의 일부 크기만 조정 */
            .banner-title { font-size: 2.4rem; }
            .banner-product-card { min-width: 300px; padding: 1rem 1.5rem; left: 5%; bottom: 8%; }
            .banner-right-section { right: 5%; width: 280px; }
            .products-grid { grid-template-columns: repeat(3, 1fr); max-width: none; } /* 3열 유지, 최대 너비 해제 */
            .product-image { height: 300px; }
            .recommendation-badge { right: 15%; }
            .badge-title { font-size: 2.2rem; }
            .badge-subtitle { font-size: 1.3rem; }
        }

        @media (max-width: 992px) {
            
            /* 📌 Header: 햄버거 메뉴 활성화/내비게이션 모바일 스타일 */
            .menu-toggle { display: block; }
            .nav { 
                display: none; 
                flex-direction: column;
                position: absolute;
                top: 70px; /* Header 높이에 맞게 조정 */
                left: 0;
                width: 100%;
                background-color: white;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
                padding: 0 5%;
                z-index: 999;
            }
            .nav.open { display: flex; }
            .nav li {
                width: 100%;
                padding: 0.8rem 0;
                border-bottom: 1px solid #eee;
                text-align: center;
            }
            .nav li:last-child { border-bottom: none; }

            /* Header Icons 순서 및 위치 조정 (기존 유지) */
            .header-icons { order: 3; margin-left: auto; }
            .logo { order: 1; }
            
            /* 📌 Main Banner (태블릿에서 전체 레이아웃 변경) */
            .main-banner { min-height: 500px; margin: 2rem 3%; }
            .banner-title { font-size: 2rem; }
            .banner-content { top: 15%; left: 5%; }
            .banner-product-card { 
                min-width: 300px; 
                left: 5%; 
                bottom: 5%; 
                padding: 1rem 1.5rem;
            }
            .banner-right-section { 
                right: 5%; 
                top: 50%;
                width: 250px;
            }
            .banner-detail-btn { 
                width: 25px; 
                height: 25px; 
                font-size: 1rem; 
                top: 10px; 
                right: 10px;
                transform: translate(0, 0); 밖으로 나가는 효과 제거
            }



            /* 📌 Products Section */
            .products-grid { 
                grid-template-columns: repeat(2, 1fr); /* 3열 -> 2열 */
                max-width: none;
            }
            .product-image { height: 250px; border-radius: 40px; } /* 높이 및 둥근 모서리 조정 */

            /* 📌 Recommendation Section */
            .recommendation-banner { min-height: 400px; border-radius: 20px; } /* 원형 -> 직사각형으로 변경 */
            .product-image-large { left: -10%; top: 50%; transform: translateY(-50%); } /* 이미지 왼쪽으로 이동 */
            .product-image-large img { width: 80%; }
            .recommendation-badge { 
                right: 5%; 
                top: 50%; 
                transform: translateY(-50%);
            }
            .badge-title { font-size: 2.5rem; }
            .badge-subtitle { font-size: 1.2rem; }
            
            /* 📌 CTA & Footer */
            .cta-grid { grid-template-columns: 1fr; }
            .footer-container { grid-template-columns: repeat(3, 1fr); } /* 3열 유지 */
        }

        @media (max-width: 768px) {
             /* 📌 Main Banner (모바일) - 콘텐츠를 모두 보이게 하기 위해 position: static으로 변경 */
            .main-banner { 
                min-height: auto; 
                margin: 1rem 2%; 
                padding: 1rem 5%; /* 내부 패딩 추가 */
                display: flex; 
                flex-direction: column; 
                align-items: flex-start; 
            }
            
            .banner-background-image { opacity: 0.3; } /* 배경 이미지 투명도 낮춤 */

            .banner-content { 
                position: static; 
                transform: none; 
                width: 100%; 
                padding: 0;
                margin-top: 0;
                margin-bottom: 1rem;
                text-align: left;
                color: #333; /* 텍스트 색상 검은색으로 변경 */
                text-shadow: none; 
            }
            .banner-title { 
                font-size: 1.6rem; 
                line-height: 1.4; 
            }
            
            /* 좌측 하단 제품 카드 (모바일에서는 일반 블록 요소처럼 보이게) */
            .banner-product-card {
                position: static; 
                transform: none;
                left: auto;
                bottom: auto; 
                width: 100%; 
                min-width: auto;
                padding: 1rem;
                margin-bottom: 1rem;
                background: white; /* 흰색 배경으로 변경하여 가독성 높임 */
                backdrop-filter: none;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); 
                border: 1px solid #eee;
            }
            .product-card-image { width: 60px; height: 60px; }

            /* 우측 중앙 제품 영역 (모바일에서 숨기거나 레이아웃 변경) */
            .banner-right-section {
                position: static;
                transform: none;
                right: auto;
                top: auto;
                width: 100%;
                padding: 0;
                background: none;
                backdrop-filter: none;
                box-shadow: none;
                display: none; /* 공간 절약을 위해 숨김 */
            }
            .banner-detail-btn { display: none; }


            /* 📌 Products Section */
            .products-section { margin: 2rem auto; }
            .section-tab { font-size: 1.5rem; }
            .products-grid { grid-template-columns: 1fr; gap: 1rem; } /* 2열 -> 1열 */
            .product-card { padding: 1rem; border-radius: 15px; }
            .product-image { height: 180px; border-radius: 10px; }
            .add-to-cart-btn { width: 40px; height: 40px; font-size: 0.7rem; bottom: 1rem; right: 1rem;}


            /* 📌 Recommendation Section (모바일) */
            .recommendation-title { font-size: 1.5rem; margin-bottom: 1.5rem; }
            .recommendation-banner { 
                min-height: 250px; 
                border-radius: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .product-image-large { display: none; } /* 큰 제품 이미지 숨김 */

            .recommendation-badge { 
                position: static; 
                transform: none; 
                text-align: center;
                width: 100%; 
                padding: 1.5rem;
                background: rgba(255, 255, 255, 0.7); 
                backdrop-filter: blur(5px); 
                color: #333; 
                text-shadow: none;
            }
            .badge-mini { font-size: 0.8rem; }
            .badge-title { font-size: 1.6rem; text-align: center; }
            .badge-subtitle { font-size: 0.9rem; text-align: center; }

            /* 📌 CTA & Footer */
            .cta-grid { gap: 1rem; }
            .cta-card { padding: 1.5rem; border-radius: 15px; }
            .cta-card h3 { font-size: 1.3rem; }
            .cta-arrow { width: 30px; height: 30px; font-size: 1rem; }

            footer { padding: 2rem 5%; margin-top: 2rem; }
            .footer-container { grid-template-columns: 1fr; gap: 1.5rem; } /* 3열 -> 1열 */
        }
    </style>
</head>
<body>
    
    <header>
        <div class="header-container">
            <div class="logo">ROUND LAB</div>
            
            <ul class="nav">
                <li><a href="#shop">SHOP</a></li>
                <li><a href="#review">REVIEW</a></li>
                <li><a href="#brand">BRAND</a></li>
                <li><a href="#center">C/S CENTER</a></li>
            </ul>
            <div class="header-icons">
            <button class="menu-toggle icon-btn" aria-label="메뉴 열기">
                <i class="fas fa-bars"></i>
            </button>
                <button class="icon-btn"><i class="fas fa-search"></i></button> 
                <a href="login.php"><button class="icon-btn"><i class="fas fa-user"></i></button> </a> 
                <a href="cart.php"><button class="icon-btn"><i class="fas fa-shopping-cart"></i></button> </a>
            </div>
        </div>
    </header>

    
    <section class="main-banner">
        
        <img src="물.jpg" 
             alt="" class="banner-background-image">
        
        <div class="water-ripple"></div> 
        
        
        <div class="banner-content" data-aos="fade-right" data-aos-duration="1000">
            <p class="banner-label">BETTER SKIN, BETTER ROUND</p>
            <h1 class="banner-title">피부와 세상을 변화시키는<br>매일의 힘, 라운드랩</h1>
        </div>
        
        
        <div class="banner-product-card" data-aos="fade-up" data-aos-delay="500">
            <div class="product-card-image">
                <img src="크림.png" alt=""> 
            </div>
            <div class="product-card-info">
                <p class="product-card-name">1025 독도 크림 80ml</p>
                <p class="product-card-price">25,600원</p>
            </div>
            
        </div>
        
        <div class="banner-right-section" data-aos="fade-left" data-aos-delay="500">
            <div class="banner-product-label">
                수분/보습<br>
                1025 독도 토너 대용량<br>
                500ML
            </div>
            
            <div class="banner-image">
                <img src="토너_대.png" alt=""> 
            </div>
            
            <button class="banner-detail-btn"><i class="fas fa-arrow-up-right-from-square"></i></button> 
        </div>
    </section>

    
    <section class="products-section">
        <div class="section-header">
            <div class="section-tab active">Best</div>
            <div class="section-tab">Set</div>
            <div class="section-tab">Sale</div>
        </div>

        <div class="products-grid">
            <?php
            // 사진에 보이는 3개의 제품 데이터
            $products = [
                ['name' => '1025 독도 토너 대용량 500ML', 'price' => '26,000원', 'image' => '토너_대.png'],
                ['name' => '1025 독도 로션 200ML', 'price' => '26,000원', 'image' => '로션.png'],
                ['name' => '자작나무 수분 선크림 50ML', 'price' => '26,000원', 'image' => '토너.png'],
            ];

            $delay = 0; // 지연 시간 변수 설정
            foreach ($products as $product) {
                echo '
                <div class="product-card" data-aos="fade-up" data-aos-delay="' . $delay . '">
                    <div class="product-image">
                        <img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">
                    </div>
                    <div class="product-info">
                        <p class="product-name">' . htmlspecialchars($product['name']) . '</p>
                        <p class="product-price">' . htmlspecialchars($product['price']) . '</p>
                    </div>
                    <button class="add-to-cart-btn"><i class="fas fa-plus"></i></button>
                </div>
                ';
                $delay += 150; // 다음 카드에 0.15초 지연 추가
            }
            ?>
        </div>
        
        </section>

    
    <section class="recommendation-section">
        <h2 class="recommendation-title" data-aos="fade-up">피부가 좋아지는 화장품</h2>
        <div class="recommendation-banner" data-aos="zoom-in" data-aos-duration="1000">
            
            <img src="물결2.jpg" 
                 alt="" class="recommendation-background-image">

            
            <div class="product-image-large" data-aos="fade-right" data-aos-delay="400">
                <img src="no.1_토너.png" alt="1025 독도 토너">
            </div>

            
            <div class="recommendation-badge" data-aos="fade-left" data-aos-delay="600">
                <p class="badge-mini">ROUND LAB 1025 DOKDO TONER</p>
                <p class="badge-title">믿고쓰는</p>
                <p class="badge-title">NO.1 국민 토너</p>
                <p class="badge-subtitle">#11관왕 #각질쏙쏙 #촉촉보습</p>
            </div>
        </div>
    </section>

    
    <section class="cta-section">
        <div class="cta-grid">
            <a href="#" class="cta-card" data-aos="fade-up">
                <h3>수분/보습</h3>
                <div class="cta-arrow">+</div>
            </a>
            <a href="#" class="cta-card" data-aos="fade-up" data-aos-delay="150">
                <h3>민감/진정</h3>
                <div class="cta-arrow">+</div>
            </a>
        </div>
    </section>

    
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>ROUND LAB</h4>
                <p>070-7717-0675</p>
                <p>평일 오전 10시 ~ 오후 4시 (점심시간 오후 12시 ~ 1시)</p>
            </div>
            <div class="footer-section">
                <h4>COMPANY</h4>
                <a href="#">공지사항</a>
                <a href="#">이용약관</a>
                <a href="#">개인정보처리방침</a>
            </div>
            <div class="footer-section">
                <h4>COMPANY</h4>
                <p>대표이사: 김라운드</p>
                <p>사업자등록번호: 123-45-67890</p>
                <p>통신판매업신고: 제2024-서울-0000호</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, 
            duration: 800, 
        });
        
        document.querySelectorAll('.section-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.section-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                alert('장바구니에 추가되었습니다.');
            });
        });
        
        // 📌 햄버거 메뉴 토글 기능 (JavaScript)
        const menuToggle = document.querySelector('.menu-toggle');
        const nav = document.querySelector('.nav');

        menuToggle.addEventListener('click', function() {
            nav.classList.toggle('open');
            const icon = menuToggle.querySelector('i');
            
            // 햄버거 아이콘 <-> 닫기 아이콘 변경
            if (nav.classList.contains('open')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times'); // 닫기(X) 아이콘
                menuToggle.setAttribute('aria-label', '메뉴 닫기');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars'); // 햄버거 아이콘
                menuToggle.setAttribute('aria-label', '메뉴 열기');
            }
        });

        // 메뉴 항목 클릭 시 메뉴 닫기 (사용자 경험 개선)
        document.querySelectorAll('.nav a').forEach(item => {
            item.addEventListener('click', function() {
                // 모바일 크기일 때만 메뉴를 닫습니다.
                if (window.innerWidth <= 992) {
                    nav.classList.remove('open');
                    const icon = menuToggle.querySelector('i');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                    menuToggle.setAttribute('aria-label', '메뉴 열기');
                }
            });
        });
    </script>
</body>
</html>