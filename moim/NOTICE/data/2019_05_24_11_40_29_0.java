package chapter05.exercise6;

public class RectangleExecute {

	public static void main(String[] args) {
		Rectangle rectangle=new Rectangle();
		rectangle.setWidth(5);
		rectangle.setHeight(6);
		
		System.out.println("����:"+ rectangle.getWidth());
		System.out.println("����: "+ rectangle.getHeight());
		System.out.println("����: "+ rectangle.calArea());
		System.out.println("�ѷ�: "+ rectangle.calPerimeter());
		System.out.println(rectangle);
	}

}
