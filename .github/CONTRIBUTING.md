# Pull Request 작성 방법
Pull Request(이하 PR) 보내는 방법에 대해서 설명합니다.

PR은 다른 사람이 만든 코드에 수정을 제안하는 기능입니다. XE의 오류, 개선, 기능 추가등 코드 수정을 제안하고자 할 경우 PR은 보내주시면 됩니다.

우리는 여러분의 기여를 기다리고 있습니다.

PR을 보내기 위해서 아래와 같은 절차가 필요합니다.

1. XE3 저장소를 포크한다.
2. 포크된 자신의 저장소의 develop 브랜치에서 코드 제안을 하기 위해 새로 브랜치를 생성한다.
3. 새로 생성한 브랜치에서 코드를 수정하고 commit 한다.
4. 수정한 내용을 자신의 저장소에 푸시한다.
5. Github의 자신을 저장소에서 PR 브랜치로 이동해서 PR을 보낸다.

> PR은 브랜치를 보내는 기능입니다.<br>
> 여러개의 코드 수정 제안을 보낼야 할 경우가 발생할 수 있기 때문에 주제에 따라 브랜치를 만들어 보내는것이 좋습니다.<Br>
> 만약 develop 브랜치에서 바로 PR을 보낼 경우 해당 PR이 승인되지 않은 상태로 다른 커밋을 푸시한다면 PR 내용이 알아볼 수 없는 상태가 될것입니다.<br>
> PR은 반드시 새로운 브랜치를 만들어서 보내 주세요.

## PR은 develop 브랜치로 보내주세요.
XE3의 master 브랜치는 배포된 버전을 유지하고 있습니다. 만약 master 브랜치로 보내실 경우 간단한 댓글과 함께 Close 될 것입니다.

PR은 반드시 **develop 브랜치**로 보내주셔야 합니다.


## 코어, 플러그인 구분
XE3는 코어와 기본으로 배포되는 *번들* 플러그인으로 구성되어 있습니다.<br>
번들 플러그인은 [Alice 테마](https://github.com/xpressengine/plugin-alice), [게시판](https://github.com/xpressengine/plugin-board), [댓글](https://github.com/xpressengine/plugin-comment) 등 여러 플러그인이 있습니다.<br>
발생한 문제점에 대해서 해결된 코드를 PR로 보내더라도 처리해할 저장소가 맞지 않다면 PR을 합칠 수 없습니다.<br>
이때는 커뮤니티 개발자들이 해당 코드가 처리되야할 저장소를 안내할 예정입니다. 번거롭더라도 안내에 따라 다시 작성해 주셔야 합니다.

## PR 보내는 방법
1. XE3 저장소를 포크합니다.
  https://github.com/xpressengine/xpressengine 에서 저장소를 포크 합니다.

  ![Fork button place](/.github/images/fork1.png)
  ![Click fork button and show modal](/.github/images/fork2.png)


2. 포크된 저장소에 PR 보내기 위해 브랜치를 생성합니다. (**Github 에서 브랜치를 만듭니다.**)
  > 예시에 사용될 PR은 관리자에서 사용된 search box 구조 변경에 대한 것입니다.
  > 로컬에서 자신의 저장소를 clone 해서 작업할 경우는 `git checkout -b feature/admin-search-box`

  ![Click branch button](/.github/images/branch1.png)
  ![Enter new branch name](/.github/images/branch2.png)


3. 추가된 브랜치에서 수정하고 수정 내용을 커밋합니다.
  > 수정해야 할 파일을 Github에서 바로 수정하고 저장합니다.
  > 로컬에서 작업할 경우에는 수정한 내용을 커밋하고 푸시 합니다.


4. 푸시된 내용을 Github에서 확인하고 `New pull request`를 클릭하고 PR을 보냅니다.
  - `xpressenigne\xpressengine` 의 브랜치를 `develop` 으로 변경합니다.

  ![Check your commits and Click new pull request button](/.github/images/pr1.png)

  **브랜치를 develop 브랜치로 변경합니다.**
  ![Change original repository branch to develop](/.github/images/pr2.png)
  

5. 내용을 작성하고 `Create pull rquest` 버튼을 클릭해서 PR을 보냅니다.


